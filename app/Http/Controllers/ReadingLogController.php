<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Response;

class ReadingLogController extends Controller
{
    public function index(Request $request): Response
    {
        $currentStreak = 0; // TODO: get current streak
        $longestStreak = 0; // TODO: get longest streak

        // entries for this month and last 7 days of previous month
        $entries = Entry::where('user_id', $request->user()->id)
            ->whereBetween('log_date', [
                now()->startOfMonth()->subDays(7),
                now()->endOfMonth(),
            ])
            ->with('book.author')
            ->get();

        return inertia('Dashboard', [
            'currentStreak' => $currentStreak,
            'longestStreak' => $longestStreak,
            'entries' => $entries,
        ]);
    }
}
