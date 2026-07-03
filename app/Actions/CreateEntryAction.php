<?php

namespace App\Actions;

use App\Models\Author;
use App\Models\Book;
use App\Models\Entry;
use App\Models\User;

class CreateEntryAction
{
    public function execute(User $user, array $data): Entry
    {
        $minutes = $this->parseDuration($data['duration']);

        $authorName = $data['author'] ?? 'Unknown Author';

        $author = Author::where('name', $authorName)->first();

        if (! $author) {
            $author = new Author;
            $author->name = $authorName;
            $author->save();
        }

        $book = null;

        if (! empty($data['book_id'])) {
            $book = Book::where('id', $data['book_id'])->first();
        }

        if (! $book) {
            $book = Book::where('title', $data['title'])
                ->where('author_id', $author->id)
                ->first();
        }

        if (! $book) {
            $book = new Book;
            $book->title = $data['title'];
            $book->author_id = $author->id;

            if (! empty($data['cover_edition_key'])) {
                $book->olid = $data['cover_edition_key'];
            }

            $book->save();
        }

        $entry = new Entry;
        $entry->book_id = $book->id;
        $entry->user_id = $user->id;
        $entry->log_date = $data['logDate'];
        $entry->duration = $minutes;
        $entry->save();

        return $entry;
    }

    private function parseDuration(string $duration): int
    {
        $minutes = 0;

        if (preg_match('/(\d+)h/', $duration, $matches)) {
            $minutes += (int) $matches[1] * 60;
        }

        if (preg_match('/(\d+)m/', $duration, $matches)) {
            $minutes += (int) $matches[1];
        }

        return $minutes;
    }
}
