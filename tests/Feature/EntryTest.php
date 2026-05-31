<?php

use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('returns 0 for current streak when there are no entries', function () {
    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(0);
});

it('returns 0 for longest streak when there are no entries', function () {
    $streak = Entry::getLongestStreak($this->user);

    expect($streak)->toBe(0);
});

it('returns 1 for current streak when the user has an entry today', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(1);
});

it('returns 1 for current streak when the user has an entry yesterday', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::yesterday(),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(1);
});

it('returns 0 for current streak when the latest entry is older than yesterday', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(3),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(0);
});

it('counts consecutive days backwards from today', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDay(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(2),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(3);
});

it('stops counting at a gap for current streak', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(2),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(1);
});

it('counts consecutive days from yesterday when no entry today', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::yesterday(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::yesterday()->subDay(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::yesterday()->subDays(2),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(3);
});

it('handles duplicate dates for current streak', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    $streak = Entry::getCurrentStreak($this->user);

    expect($streak)->toBe(1);
});

it('returns 1 for longest streak with a single entry', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    $streak = Entry::getLongestStreak($this->user);

    expect($streak)->toBe(1);
});

it('returns the length of a single streak', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDay(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(2),
    ]);

    $streak = Entry::getLongestStreak($this->user);

    expect($streak)->toBe(3);
});

it('returns the longest streak when there are multiple streaks', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(5),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(6),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDays(7),
    ]);

    $streak = Entry::getLongestStreak($this->user);

    expect($streak)->toBe(3);
});

it('handles duplicate dates for longest streak', function () {
    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today(),
    ]);

    Entry::factory()->create([
        'user_id' => $this->user->id,
        'log_date' => Carbon::today()->subDay(),
    ]);

    $streak = Entry::getLongestStreak($this->user);

    expect($streak)->toBe(2);
});
