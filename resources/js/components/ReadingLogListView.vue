<template>
    <div>
        <div v-for="(week, weekIndex) in weekRows" :key="week.week" class="">
            <div class="p-2 border-t border-b border-gray-200">{{  weekRange(week, weekIndex) }}</div>

            <div v-for="day in week.days.slice().sort((a, b) => b.dayOfWeek - a.dayOfWeek)" :key="`${weekIndex}-${day.date}`" class="p-2">
                <div class="grid grid-cols-[150px_1fr] w-full pt-2">
                    <div class="">
                        <div class="text-xl font-bold">{{ day.date }}</div>
                        <div class="text-gray-500">{{ dayNames[day.dayOfWeek] }}</div>
                        <div>
                            <div 
                                class="p-2 mr-8 bg-orange-200 rounded-xl flex"
                            >
                                <Flame :size="24" class="text-amber-500 mr-2" />
                                <span 
                                    class="text-orange-600 font-bold text-sm relative mr-2"
                                    style="top: 2px;"
                                >
                                    ####
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div v-for="entry in day.entries" :key="entry.bookTitle + entry.duration" class="mb-2 ml-2 mr-2 rounded-md bg-sky-100 p-2 min-w-0 break-words border-l-6 border-l-sky-600 text-sky-600">
                            <div class="font-bold">{{ entry.bookTitle }}</div>
                            <div class="text-sm">{{ entry.bookAuthor }}</div>
                            <div class="font-bold">{{ entry.duration }} minutes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <CalendarViewLoader v-if="props.isLoading" />
</template>

<script setup lang="ts">
import { Flame } from 'lucide-vue-next';
import { computed } from 'vue';
import type { ReadingLogMonth, GroupedReadingLogEntries, ReadingLogWeek } from '@/types';
import { useReadingLogWeeks } from '../composables/useReadingLogWeeks';
import CalendarViewLoader from './CalendarViewLoader.vue';

const monthNames = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

const props = defineProps<{
    currentMonth: ReadingLogMonth;
    entries: GroupedReadingLogEntries;
    isLoading: boolean;
}>();

const weekRows = computed<ReadingLogWeek[]>(() => useReadingLogWeeks(props.entries, props.currentMonth).slice().sort((a, b) => b.week - a.week));

const weekRange = (week: ReadingLogWeek, index: number) => {
    const firstDay = week.days.find(d => d.dayOfWeek === 0)?.date ?? week.days[0].date;
    const lastDay = week.days.find(d => d.dayOfWeek === 6)?.date ?? week.days[6].date;
    const firstMonthName = monthNames[props.currentMonth.month];

    let range = `${firstMonthName} ${firstDay}`;

    if(firstDay > lastDay) {
        if(index === 0) {
            const nextMonthName = monthNames[(props.currentMonth.month + 1) % 12];
            range += ` - ${nextMonthName} ${lastDay}`;
        } else {
            const previousMonthName = monthNames[(props.currentMonth.month - 1 + 12) % 12];
            range += ` - ${previousMonthName} ${lastDay}`;
        }
    } else {
        range += ` - ${firstMonthName} ${lastDay}`;
    }

    return range;
};
</script>

<style scoped>

</style>