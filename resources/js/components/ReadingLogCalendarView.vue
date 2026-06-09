<template>
    <div class="min-w-[965px]">
        <Table class="border-t-1 table-fixed text-base">
            <TableHeader>
                <TableRow>
                    <TableHead v-for="(day, index) in daysOfTheWeek" :key="day" :class="{ 'border-l-1': index > 0 }">
                        {{ day }}
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="(week, weekIndex) in weekRows" :key="week.week">
                    <TableCell 
                        v-for="(day, dayIndex) in week.days" 
                        :key="day.date" 
                        class="p-0 whitespace-normal align-top relative"
                    >
                        <div v-if="dayIndex > 0" class="absolute inset-y-0 w-px bg-border pointer-events-none"></div>
                        <div class="min-h-28 p-0 m-0">
                            <div 
                                class="p-2 font-bold"
                                :class="{ 
                                    
                                    'text-gray-400': !day.isCurrentMonth,
                                }"
                            >
                                {{ day.date }}
                            </div>  

                            <ReadingLogCalendarViewStreak 
                                v-if="day.entries.length > 0"
                                :previous-day="week.days[dayIndex - 1] || { entries: [] }"
                                :day="day"
                                :day-index="dayIndex"
                                :next-day="week.days[dayIndex + 1] || { entries: [] }"
                                :previous-week="weekRows[weekIndex - 1] || { days: [] }"
                                :next-week="weekRows[weekIndex + 1] || { days: [] }"
                                :streak-length="streakDayInfo[`${weekIndex}-${dayIndex}`] ?? 0"
                            />

                            <div 
                                class="p-2 flex-1"
                            >
                                <div 
                                    v-for="entry in day.entries" 
                                    :key="entry.bookTitle + entry.duration"
                                    class="mb-2 ml-2 mr-2 rounded-md bg-sky-100 p-2 min-w-0 break-words border-l-6 border-l-sky-600 text-sky-600"
                                >
                                    <div class="font-bold">{{ entry.bookTitle }}</div>
                                    <div class="text-sm">{{ entry.bookAuthor }}</div>
                                    <div class="font-bold">{{ entry.duration }} minutes</div>
                                </div>
                            </div>
                        </div>
                    </TableCell>
                </TableRow>                
            </TableBody>
        </Table>
    </div>
    <CalendarViewLoader v-if="props.isLoading" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Table from '@/components/ui/table/Table.vue';
import type { ReadingLogMonth, ReadingLogWeek, GroupedReadingLogEntries, ReadingLogEntry} from '@/types';
import CalendarViewLoader from './CalendarViewLoader.vue';
import ReadingLogCalendarViewStreak from './ReadingLogCalendarViewStreak.vue';
import TableBody from './ui/table/TableBody.vue';
import TableCell from './ui/table/TableCell.vue';
import TableHead from './ui/table/TableHead.vue';
import TableHeader from './ui/table/TableHeader.vue';
import TableRow from './ui/table/TableRow.vue';

const props = defineProps<{
    currentMonth: ReadingLogMonth;
    entries: GroupedReadingLogEntries;
    isLoading: boolean;
}>();

const daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

const getDateKey = (year: number, month: number, day: number): string => {
    return `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
};

const getEntriesForDate = (year: number, month: number, day: number) => {
    const dateKey = getDateKey(year, month, day);
    const entriesForDate = props.entries[dateKey] || [];

    return entriesForDate.map(entry => ({
        bookAuthor: entry.book.author.name,
        bookTitle: entry.book.title,
        duration: entry.duration,
    }));
};

const buildRows = (): ReadingLogWeek[] => {
    const previousMonth: ReadingLogMonth = {
        month: props.currentMonth.month === 0 ? 11 : props.currentMonth.month - 1,
        year: props.currentMonth.month === 0 ? props.currentMonth.year - 1 : props.currentMonth.year,
    };

    const maxDayOfPreviousMonth = new Date(previousMonth.year, previousMonth.month + 1, 0).getDate();

    const weeks: ReadingLogWeek[] = [];
    const date = new Date(props.currentMonth.year, props.currentMonth.month, 1);
    const daysInMonth = new Date(props.currentMonth.year, props.currentMonth.month + 1, 0).getDate();
    const firstDay = date.getDay();
    let week: ReadingLogWeek = {
        week: 1,
        year: props.currentMonth.year,
        days: []
    }

    for(let i = 0; i < firstDay; i++) {
        week.days.push({
            date: maxDayOfPreviousMonth - firstDay + i + 1,
            entries: getEntriesForDate(previousMonth.year, previousMonth.month, maxDayOfPreviousMonth - firstDay + i + 1),
            isCurrentMonth: false,
        });
    }

    for(let day = 1; day <= daysInMonth; day++) {
        week.days.push({
            date: day,
            entries: getEntriesForDate(props.currentMonth.year, props.currentMonth.month, day),
            isCurrentMonth: true,
        });

        if (week.days.length === 7) {
            weeks.push(week);
            week = {
                week: week.week + 1,
                year: props.currentMonth.year,
                days: [],
            }
        }
    }

    if(week.days.length === 0) {
        return weeks;
    }
    
    const remainingDays = 7 - week.days.length;

    for(let i = 0; i < remainingDays; i++) {
        week.days.push({
            date: i + 1,
            entries: getEntriesForDate(props.currentMonth.year, props.currentMonth.month + 1, i + 1),
            isCurrentMonth: false
        });
    }

    weeks.push(week);

    return weeks;
};

const weekRows = computed<ReadingLogWeek[]>(() => buildRows());

const streakDayInfo = computed<Record<string, number>>(() => {
    const weeks = weekRows.value;
    const info: Record<string, number> = {};

    const flat: { weekIdx: number; dayIdx: number; entries: ReadingLogEntry[] }[] = [];

    for (let wi = 0; wi < weeks.length; wi++) {
        for (let di = 0; di < weeks[wi].days.length; di++) {
            flat.push({ weekIdx: wi, dayIdx: di, entries: weeks[wi].days[di].entries });
        }
    }

    let i = 0;

    while (i < flat.length) {
        if (flat[i].entries.length > 0) {
            let j = i;

            while (j < flat.length && flat[j].entries.length > 0) {
                j++;
            }

            const streakLength = j - i;

            for (let k = i; k < j; k++) {
                info[`${flat[k].weekIdx}-${flat[k].dayIdx}`] = streakLength;
            }

            i = j;
        } else {
            i++;
        }
    }

    return info;
});
</script>

<style scoped>

</style>
