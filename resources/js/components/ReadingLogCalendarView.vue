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
                <TableRow v-for="week in weekRows" :key="week.week">
                    <TableCell 
                        v-for="(day, dayIndex) in week.days" 
                        :key="day.date" 
                        class="p-0 whitespace-normal align-top"
                    >
                        <div class="min-h-28 p-0 m-0">
                            <div 
                                class="p-2 font-bold"
                                :class="{ 
                                    'border-l-1': dayIndex > 0,
                                    'text-gray-400': !day.isCurrentMonth,
                                }"
                            >
                                {{ day.date }}
                            </div>  

                            <div 
                                class="py-2 bg-orange-200"
                                :class="{ 'hidden': dayIndex%2 === 0 }"
                            >
                                streak
                            </div>

                            <div 
                                class="p-2"
                                :class="{ 'border-l-1': dayIndex > 0 }"
                            >
                                <div 
                                    v-for="entry in day.entries" 
                                    :key="entry.bookTitle + entry.duration"
                                    class="mb-2 rounded-md bg-sky-100 p-2 min-w-0 w-full break-words border-l-6 border-l-sky-600 text-sky-600"
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
    <CalendarViewLoader v-if="isLoading" />
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Table from '@/components/ui/table/Table.vue';
import type { ReadingLogMonth, ReadingLogWeek, GroupedReadingLogEntries} from '@/types';
import CalendarViewLoader from './CalendarViewLoader.vue';
import TableBody from './ui/table/TableBody.vue';
import TableCell from './ui/table/TableCell.vue';
import TableHead from './ui/table/TableHead.vue';
import TableHeader from './ui/table/TableHeader.vue';
import TableRow from './ui/table/TableRow.vue';

const props = defineProps<{
    currentMonth: ReadingLogMonth;
    entries: GroupedReadingLogEntries;
}>();

const isLoading = ref(false);

watch(() => props.currentMonth, () => {
    weekRows.value = buildRows();
}, { deep: true });

const previousMonth: ReadingLogMonth = {
    month: props.currentMonth.month === 0 ? 11 : props.currentMonth.month - 1,
    year: props.currentMonth.month === 0 ? props.currentMonth.year - 1 : props.currentMonth.year,
};

const daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const maxDayOfPreviousMonth = new Date(previousMonth.year, previousMonth.month + 1, 0).getDate();

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

const weekRows = ref<ReadingLogWeek[]>(buildRows());
</script>

<style scoped>

</style>
