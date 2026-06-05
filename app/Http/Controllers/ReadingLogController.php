<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadingLogGetRequest;
use App\Models\Entry;
use Carbon\Carbon;
use Inertia\Response;

class ReadingLogController extends Controller
{
    public function index(ReadingLogGetRequest $request): Response
    {
        $date = $request->getDate();
        $month = Carbon::parse($date.'-01');
        $currentStreak = Entry::getCurrentStreak($request->user());
        $longestStreak = Entry::getLongestStreak($request->user());

        $entries = Entry::where('user_id', $request->user()->id)
            ->whereBetween('log_date', [
                $month->copy()->startOfMonth()->subDays(7),
                $month->copy()->endOfMonth()->addDays(7),
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
            'currentMonth' => [
                'year' => $month->format('Y'),
                'month' => intval($month->format('m')),
            ],
        ]);
    }
}
