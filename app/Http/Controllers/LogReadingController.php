<?php

namespace App\Http\Controllers;

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

    public function bookSearch(Request $request): JsonResponse
    {
        $url = env('OPEN_LIBRARY_API_URL').'?q='.urlencode($request->input('q'));
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
        $url = str_replace('{cover_edition_key}', $request->input('id'), env('OPEN_LIBRARY_COVER_URL'));

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
