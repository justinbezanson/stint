import type { GroupedReadingLogEntries, ReadingLogWeek, ReadingLogMonth, ReadingLogEntry } from '@/types';

let streakCount: number = 0;

const getDateKey = (year: number, month: number, day: number): string => {
    return `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
};

const getStreakCount = (entries: ReadingLogEntry[]) => {
    if(entries.length > 0) {
        streakCount++;
    } else {
        streakCount = 0;
    }

    return streakCount;
};

const getEntriesForDate = (entries: GroupedReadingLogEntries, year: number, month: number, day: number): ReadingLogEntry[] => {
    const dateKey = getDateKey(year, month, day);
    const entriesForDate = entries[dateKey] || [];

    return entriesForDate.map(entry => ({
        bookAuthor: entry.book.author.name,
        bookTitle: entry.book.title,
        duration: entry.duration,
    }));
};

export function useReadingLogWeeks(entries: GroupedReadingLogEntries, currentMonth: ReadingLogMonth): ReadingLogWeek[] {
    const previousMonth: ReadingLogMonth = {
        month: currentMonth.month === 0 ? 11 : currentMonth.month - 1,
        year: currentMonth.month === 0 ? currentMonth.year - 1 : currentMonth.year,
    };

    const maxDayOfPreviousMonth = new Date(previousMonth.year, previousMonth.month + 1, 0).getDate();

    const weeks: ReadingLogWeek[] = [];
    const date = new Date(currentMonth.year, currentMonth.month, 1);
    const daysInMonth = new Date(currentMonth.year, currentMonth.month + 1, 0).getDate();
    const firstDay = date.getDay();
    let week: ReadingLogWeek = {
        week: 1,
        year: currentMonth.year,
        days: []
    }

    for(let i = 0; i < firstDay; i++) {
        const dayEntries = getEntriesForDate(entries, previousMonth.year, previousMonth.month, maxDayOfPreviousMonth - firstDay + i + 1);
        week.days.push({
            date: maxDayOfPreviousMonth - firstDay + i + 1,
            entries: dayEntries,
            isCurrentMonth: false,
            dayOfWeek: i,
            streakCount: getStreakCount(dayEntries),
        });
    }

    for(let day = 1; day <= daysInMonth; day++) {
        const dayEntries = getEntriesForDate(entries, currentMonth.year, currentMonth.month, day);
        week.days.push({
            date: day,
            entries: dayEntries,
            streakCount: getStreakCount(dayEntries),
            isCurrentMonth: true,
            dayOfWeek: (firstDay + day - 1) % 7
        });

        if (week.days.length === 7) {
            weeks.push(week);
            week = {
                week: week.week + 1,
                year: currentMonth.year,
                days: [],
            }
        }
    }

    if(week.days.length === 0) {
        return weeks;
    }
    
    const remainingDays = 7 - week.days.length;

    for(let i = 0; i < remainingDays; i++) {
        const dayEntries = getEntriesForDate(entries, currentMonth.year, currentMonth.month + 1, i + 1);
        week.days.push({
            date: i + 1,
            entries: dayEntries,
            streakCount: getStreakCount(dayEntries),
            isCurrentMonth: false,
            dayOfWeek: (firstDay + daysInMonth + i) % 7
        });
    }

    weeks.push(week);

    return weeks;
};