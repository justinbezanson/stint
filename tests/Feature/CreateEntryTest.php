<?php

use App\Actions\CreateEntryAction;
use App\Models\Author;
use App\Models\Book;
use App\Models\Entry;
use App\Models\User;

// ─── CreateEntryAction Unit Tests ────────────────────────────────────────────

describe('CreateEntryAction', function () {
    it('parses hours only', function () {
        $action = new CreateEntryAction;

        $entry = $action->execute(User::factory()->create(), [
            'duration' => '2h',
            'logDate' => '2026-06-30',
            'title' => 'Test Book',
            'author' => 'Test Author',
        ]);

        expect($entry->duration)->toBe(120);
    });

    it('parses minutes only', function () {
        $action = new CreateEntryAction;

        $entry = $action->execute(User::factory()->create(), [
            'duration' => '45m',
            'logDate' => '2026-06-30',
            'title' => 'Test Book',
            'author' => 'Test Author',
        ]);

        expect($entry->duration)->toBe(45);
    });

    it('parses hours and minutes combined', function () {
        $action = new CreateEntryAction;

        $entry = $action->execute(User::factory()->create(), [
            'duration' => '1h30m',
            'logDate' => '2026-06-30',
            'title' => 'Test Book',
            'author' => 'Test Author',
        ]);

        expect($entry->duration)->toBe(90);
    });

    it('uses Unknown Author when none provided', function () {
        $action = new CreateEntryAction;

        $entry = $action->execute(User::factory()->create(), [
            'duration' => '30m',
            'logDate' => '2026-06-30',
            'title' => 'Test Book',
        ]);

        expect($entry->book->author->name)->toBe('Unknown Author');
    });

    it('reuses existing author by name', function () {
        $author = Author::factory()->create(['name' => 'Jane Austen']);
        $action = new CreateEntryAction;

        $action->execute(User::factory()->create(), [
            'duration' => '30m',
            'logDate' => '2026-06-30',
            'title' => 'Pride and Prejudice',
            'author' => 'Jane Austen',
        ]);

        expect(Author::where('name', 'Jane Austen')->count())->toBe(1);
    });

    it('reuses existing book by id', function () {
        $action = new CreateEntryAction;
        $user = User::factory()->create();

        $action->execute($user, [
            'duration' => '30m',
            'logDate' => '2026-06-30',
            'title' => 'Existing Book',
            'author' => 'Some Author',
            'book_id' => 1,
        ]);

        $action->execute($user, [
            'duration' => '45m',
            'logDate' => '2026-06-30',
            'title' => 'Existing Book',
            'author' => 'Some Author',
            'book_id' => 1,
        ]);

        expect(Book::where('id', 1)->count())->toBe(1);
        expect(Entry::count())->toBe(2);
    });

    it('reuses existing book by title and author', function () {
        $action = new CreateEntryAction;
        $user = User::factory()->create();

        $action->execute($user, [
            'duration' => '30m',
            'logDate' => '2026-06-30',
            'title' => 'Same Book',
            'author' => 'Same Author',
        ]);

        $action->execute($user, [
            'duration' => '45m',
            'logDate' => '2026-07-01',
            'title' => 'Same Book',
            'author' => 'Same Author',
        ]);

        expect(Book::where('title', 'Same Book')->count())->toBe(1);
        expect(Entry::count())->toBe(2);
    });

    it('stores id on book when provided', function () {
        $action = new CreateEntryAction;

        $entry = $action->execute(User::factory()->create(), [
            'duration' => '30m',
            'logDate' => '2026-06-30',
            'title' => 'OL Book',
            'author' => 'OL Author',
            'book_id' => 1,
        ]);

        expect($entry->book->id)->toBe(1);
    });

    it('creates entry with correct user and date', function () {
        $action = new CreateEntryAction;
        $user = User::factory()->create();

        $entry = $action->execute($user, [
            'duration' => '30m',
            'logDate' => '2026-07-04',
            'title' => 'Fireworks',
            'author' => 'Independence Author',
        ]);

        expect($entry->user_id)->toBe($user->id);
        expect($entry->log_date)->toBe('2026-07-04');
    });
});

// ─── Feature Tests ───────────────────────────────────────────────────────────

describe('POST /create-entry', function () {
    it('guests are redirected to the login page', function () {
        $this->post(route('create-entry'))->assertRedirect(route('login'));
    });

    it('rejects a request with missing duration', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'logDate' => '2026-06-30',
                'title' => 'A Book',
                'author' => 'An Author',
            ])
            ->assertSessionHasErrors('duration');
    });

    it('rejects a request with missing logDate', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'duration' => '30m',
                'title' => 'A Book',
                'author' => 'An Author',
            ])
            ->assertSessionHasErrors('logDate');
    });

    it('rejects manual entry with missing title', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'duration' => '30m',
                'logDate' => '2026-06-30',
                'author' => 'An Author',
            ])
            ->assertSessionHasErrors('title');
    });

    it('rejects manual entry with missing author', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'duration' => '30m',
                'logDate' => '2026-06-30',
                'title' => 'A Book',
            ])
            ->assertSessionHasErrors('author');
    });

    it('allows missing title and author when book_id is provided', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'duration' => '30m',
                'logDate' => '2026-06-30',
                'book_id' => 1,
            ])
            ->assertSessionDoesntHaveErrors(['title', 'author']);
    });

    it('creates an entry from manual data', function () {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('create-entry'), [
            'duration' => '1h',
            'logDate' => '2026-06-30',
            'title' => 'Manual Book',
            'author' => 'Manual Author',
        ]);

        expect(Entry::count())->toBe(1);
        expect(Entry::first()->duration)->toBe(60);
        expect(Entry::first()->user_id)->toBe($user->id);
    });

    it('creates an entry from Open Library data', function () {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('create-entry'), [
            'duration' => '45m',
            'logDate' => '2026-06-30',
            'title' => 'OL Book',
            'author' => 'OL Author',
            'book_id' => 1,
            'subtitle' => 'A Subtitle',
            'cover_edition_key' => 'OL123M',
        ]);

        expect(Entry::count())->toBe(1);
        expect(Entry::first()->book->id)->toBe(1);
        expect(Entry::first()->book->author->name)->toBe('OL Author');
    });

    it('returns Inertia response on success', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('create-entry'), [
                'duration' => '30m',
                'logDate' => '2026-06-30',
                'title' => 'Inertia Book',
                'author' => 'Inertia Author',
            ])
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('LogReading'));
    });
});
