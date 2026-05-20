<template>
    <div class="min-w-[965px]">
        <Table class="border-t-1 table-fixed">
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
                        :class="{ 'border-l-1': dayIndex > 0 }"
                    >
                        <div class="min-h-28">
                            {{ day.date }}
                        </div>
                    </TableCell>
                </TableRow>                
            </TableBody>
        </Table>
    </div>
</template>

<script setup lang="ts">
import Table from '@/components/ui/table/Table.vue';
import type { ReadingLogMonth, ReadingLogWeek } from '@/types';
import TableHead from './ui/table/TableHead.vue';
import TableHeader from './ui/table/TableHeader.vue';
import TableRow from './ui/table/TableRow.vue';
import TableBody from './ui/table/TableBody.vue';
import TableCell from './ui/table/TableCell.vue';


const props = defineProps<{
    currentMonth: ReadingLogMonth;
}>();

const previousMonth: ReadingLogMonth = {
    month: props.currentMonth.month === 0 ? 11 : props.currentMonth.month - 1,
    year: props.currentMonth.month === 0 ? props.currentMonth.year - 1 : props.currentMonth.year,
};

const daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
let maxDayOfPreviousMonth = new Date(previousMonth.year, previousMonth.month + 1, 0).getDate();

const buildRows = (): ReadingLogWeek[] => {
    const weeks: ReadingLogWeek[] = [];
    let day;

    let date = new Date(props.currentMonth.year, props.currentMonth.month, 1);
    let daysInMonth = new Date(props.currentMonth.year, props.currentMonth.month + 1, 0).getDate();
    let firstDay = date.getDay();
    let week: ReadingLogWeek = {
        week: 1,
        year: props.currentMonth.year,
        days: []
    }

    for(let i = 0; i < firstDay; i++) {
        week.days.push({
            date: maxDayOfPreviousMonth - firstDay + i + 1,
            entries: [],
        });
    }

    for(let day = 1; day <= daysInMonth; day++) {
        week.days.push({
            date: day,
            entries: [],
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

    let remainingDays = 7 - week.days.length;
    for(let i = 0; i < remainingDays; i++) {
        week.days.push({
            date: i + 1,
            entries: [],
        });
    }

    weeks.push(week);

    return weeks;
};

const weekRows: ReadingLogWeek[] = buildRows();
</script>

<style scoped>

</style>
