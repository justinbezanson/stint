<?php

namespace App\Http\Controllers;

use App\Actions\CreateEntryAction;
use App\Http\Requests\CreateEntryRequest;
use App\Models\Entry;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class LogReadingController extends Controller
{
    public function index(Request $request): Response
    {
        $recentBooks = Book::select('books.*')
            ->join('entries', 'books.id', '=', 'entries.book_id')
            ->where('entries.user_id', $request->user()->id)
            ->where('entries.log_date', '>=', now()->subDays(30))
            ->groupBy('books.id')
            ->orderByRaw('MAX(entries.log_date) DESC')
            ->limit(5)
            ->with('author')
            ->get();

        $recentBooks = $recentBooks->map(function ($book) {
            return [
                'key' => $book->id,
                'title' => $book->title,
                'author_name' => explode(', ', $book->author->name),
                'cover_edition_key' => $book->olid,
                'author_key' => $book->author->id,
            ];
        });

        return inertia('LogReading', [
            'recentBooks' => $recentBooks,
        ]);
    }

    public function createEntry(CreateEntryRequest $request, CreateEntryAction $action)
    {
        Gate::authorize('create', Entry::class);

        $action->execute($request->user(), $request->validated());

        return inertia('LogReading', [

        ]);
    }

    public function bookSearch(Request $request): JsonResponse
    {
        $url = env('OPEN_LIBRARY_API_URL').'?q='.urlencode($request->input('q')).'&limit=10';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, env('OPEN_LIBRARY_API_TIMEOUT'));
        curl_setopt($ch, CURLOPT_USERAGENT, env('OPEN_LIBRARY_API_USER_AGENT'));

        $response = curl_exec($ch);
        $data = null;
        $message = null;
        $status = 200;

        if (curl_errno($ch)) {
            $message = 'Error: '.curl_error($ch);
            $status = 500;
        } else {
            $data = json_decode($response, true);
        }

        $response = [
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $status);
    }

    public function bookCover(Request $request)
    {
        $size = $request->input('size') ?? 'S';
        $url = str_replace('{cover_edition_key}', $request->input('id'), env('OPEN_LIBRARY_COVER_URL'));
        $url = str_replace('{cover_size}', $size, $url);

        return response()->stream(function () use ($url) {
            $stream = fopen($url, 'r');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
