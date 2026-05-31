<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    use HasFactory;
    //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public static function getCurrentStreak(User $user): int
    {
        $dates = Entry::where('user_id', $user->id)
            ->select('log_date')
            ->distinct()
            ->orderBy('log_date', 'desc')
            ->pluck('log_date');

        if ($dates->isEmpty()) {
            return 0;
        }

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $latestDate = Carbon::parse($dates->first());

        if (! $latestDate->equalTo($today) && ! $latestDate->equalTo($yesterday)) {
            return 0;
        }

        $streak = 1;
        $previousDate = $latestDate;

        for ($i = 1; $i < $dates->count(); $i++) {
            $currentDate = Carbon::parse($dates[$i]);

            if ($currentDate->equalTo($previousDate->copy()->subDay())) {
                $streak++;
                $previousDate = $currentDate;
            } else {
                break;
            }
        }

        return $streak;
    }

    public static function getLongestStreak(User $user): int
    {
        $dates = Entry::where('user_id', $user->id)
            ->select('log_date')
            ->distinct()
            ->orderBy('log_date', 'asc')
            ->pluck('log_date');

        if ($dates->isEmpty()) {
            return 0;
        }

        $longestStreak = 1;
        $currentStreak = 1;
        $previousDate = Carbon::parse($dates->first());

        for ($i = 1; $i < $dates->count(); $i++) {
            $currentDate = Carbon::parse($dates[$i]);

            if ($currentDate->equalTo($previousDate->copy()->addDay())) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
            }

            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }

            $previousDate = $currentDate;
        }

        return $longestStreak;
    }
}
