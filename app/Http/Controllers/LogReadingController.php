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
        $response = [
            'message' => $request->input('q'),
        ];

        return response()->json($response);
    }
}
