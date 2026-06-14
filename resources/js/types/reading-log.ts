export type ReadingLogMonth = {
    month: number;
    year: number;
}

export type ReadingLogEntry = {
    bookTitle: string;
    bookAuthor: string;
    duration: number; // Duration in minutes
};

export type ReadingLogDay = {
    date: number;
    entries: ReadingLogEntry[];
    isCurrentMonth: boolean;
    dayOfWeek: number;
    streakCount: number;
}

export type ReadingLogWeek = {
    week: number;
    year: number;
    days: ReadingLogDay[];
}

export type Author = {
    id: number;
    name: string;
    olid: string | null;
    created_at: string;
    updated_at: string;
};

export type Book = {
    id: number;
    title: string;
    author_id: number;
    author: Author;
    created_at: string;
    updated_at: string;
};

export type ReadingLogEntryRecord = {
    id: number;
    user_id: number;
    book_id: number;
    log_date: string;
    duration: number;
    book: Book;
    created_at: string;
    updated_at: string;
};

export type GroupedReadingLogEntries = Record<string, ReadingLogEntryRecord[]>;

export type DashboardProps = {
    currentStreak: number;
    longestStreak: number;
    entries: GroupedReadingLogEntries;
    currentMonth: ReadingLogMonth;
}

export type BookSearchResult = {
    title: string;
    author_name?: string[];
    cover_edition_key?: string;
}