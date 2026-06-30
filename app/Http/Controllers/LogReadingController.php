<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class LogReadingController extends Controller
{
    public function index(Request $request): Response
    {
        // TODO: get recent books read

        return inertia('LogReading', [
            'test' => 'Hello, world!',
        ]);
    }

    public function createEntry(Request $request): Response
    {
        // $entry = Entry::create([
        //     'user_id' => $request->user()->id,
        //     'book_id' => $request->input('book_id'),
        //     'book_title' => $request->input('book_title'),
        //     'book_author' => $request->input('book_author'),
        //     'book_cover' => $request->input('book_cover'),
        //     'logDate' => $request->input('log_date'),
        //     'duration' => $request->input('duration'),
        // ]);

        return inertia('LogReading', [
            // 'entry' => $entry,
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
