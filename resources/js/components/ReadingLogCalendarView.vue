<template>
    <Table class="w-full border-t-1">
        <TableHeader>
            <TableRow>
                <TableHead v-for="(day, index) in daysOfTheWeek" :key="day" :class="{ 'border-l-1': index > 0 }">
                    {{ day }}
                </TableHead>
            </TableRow>
            <TableBody>
                
            </TableBody>
        </TableHeader>
    </Table>
</template>

<script setup lang="ts">
import Table from '@/components/ui/table/Table.vue';
//import type { ReadingLogMonth, ReadingLogWeek } from '@/types';
import TableHead from './ui/table/TableHead.vue';
import TableHeader from './ui/table/TableHeader.vue';
import TableRow from './ui/table/TableRow.vue';

// const props = defineProps<{
//     currentMonth: ReadingLogMonth;
// }>();

// const previousMonth: ReadingLogMonth = {
//     month: props.currentMonth.month === 0 ? 11 : props.currentMonth.month - 1,
//     year: props.currentMonth.month === 0 ? props.currentMonth.year - 1 : props.currentMonth.year,
// };
// const nextMonth: ReadingLogMonth = {
//     month: props.currentMonth.month === 11 ? 0 : props.currentMonth.month + 1,
//     year: props.currentMonth.month === 11 ? props.currentMonth.year + 1 : props.currentMonth.year,
// };

const daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
// let dayOfMonth = 0;
// let maxDayOfCurrentMonth = new Date(props.currentMonth.year, props.currentMonth.month + 1, 0).getDate();
// let maxDayOfPreviousMonth = new Date(previousMonth.year, previousMonth.month + 1, 0).getDate();

//const buildRows = (): ReadingLogWeek[] => {
    //const weeks: ReadingLogWeek[] = [];
    // let week: number = 0;
    // let day;

    // while((day = incrementDayOfTheMonth()) !== false) {
    //     let date = new Date(props.currentMonth.year, props.currentMonth.month, day as number);
    //     let dayOfWeek = date.getDay();
    //     let weekOfTheyear = Math.ceil((date.getDate() + 6 - dayOfWeek) / 7);
    //     let diff = 7 - dayOfWeek;

    //     while(dayOfWeek < 7) {}
    //         let week: ReadingLogWeek = {
    //             week: weekOfTheyear,
    //             year: props.currentMonth.year,
    //             days: [],
    //         }
    //     }

    //     //weeks.push(week);
    // }

    //return weeks;
//};

// const incrementDayOfTheMonth: () => number | boolean = () => {
//     dayOfMonth++;

//     if (dayOfMonth > maxDayOfCurrentMonth) {
//         return false;
//     }

//     return dayOfMonth;
// };

//const weekRows: ReadingLogWeek[] = buildRows();
</script>

<style scoped>

</style>
