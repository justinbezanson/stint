<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Response;

class ReadingLogController extends Controller
{
    public function index(Request $request): Response
    {
        $currentStreak = Entry::getCurrentStreak($request->user());
        $longestStreak = Entry::getLongestStreak($request->user());

        // entries for this month and last 7 days of previous month
        $entries = Entry::where('user_id', $request->user()->id)
            ->whereBetween('log_date', [
                now()->startOfMonth()->subDays(7),
                now()->endOfMonth(),
            ])
            ->with('book.author')
            ->get();

        $formattedEntries = [];
        foreach ($entries as $entry) {
            if (! isset($formattedEntries[$entry->log_date])) {
                $formattedEntries[$entry->log_date] = [];
            }

            $formattedEntries[$entry->log_date][] = $entry;
        }

        return inertia('Dashboard', [
            'currentStreak' => $currentStreak,
            'longestStreak' => $longestStreak,
            'entries' => $formattedEntries,
        ]);
    }
}
