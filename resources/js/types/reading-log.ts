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
}

export type ReadingLogWeek = {
    week: number;
    year: number;
    days: ReadingLogDay[];
}