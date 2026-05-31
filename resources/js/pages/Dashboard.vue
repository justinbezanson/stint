<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { CalendarDays, List, ChevronLeft, ChevronRight, Flame } from 'lucide-vue-next'
import { ref } from 'vue';
import ReadingLogCalendarView from '@/components/ReadingLogCalendarView.vue';
import ReadingLogListView from '@/components/ReadingLogListView.vue';
import Button from '@/components/ui/button/Button.vue';
import SwitchLogView from '@/components/ui/switch-log-view/SwitchLogView.vue';
import { dashboard } from '@/routes';
import type { ReadingLogMonth, GroupedReadingLogEntries } from '@/types/reading-log';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const props = defineProps<{
    currentStreak: number;
    longestStreak: number;
    entries: GroupedReadingLogEntries;
}>();

const today = new Date();
const monthNames = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

const logView = ref('calendar');
const currentMonth = ref<ReadingLogMonth>({
    month: today.getMonth(),
    year: today.getFullYear(),
});

const previousMonth = () => {
    if (currentMonth.value.month === 0) {
        currentMonth.value.month = 11;
        currentMonth.value.year -= 1;
    } else {
        currentMonth.value.month -= 1;
    }
};

const nextMonth = () => {
    if (currentMonth.value.year === today.getFullYear() && currentMonth.value.month === today.getMonth()) {
        return;
    }

    if (currentMonth.value.month === 11) {
        currentMonth.value.month = 0;
        currentMonth.value.year += 1;
    } else {
        currentMonth.value.month += 1;
    }
};

console.log(props.entries); 

</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid grid-cols-2 gap-4 border-b-1 border-gray-200 pb-4">
            <div class="text-left"><h1>Reading Log</h1></div>
            <div class="text-right">
                <Button class="btn" variant="outline">Print</Button>
                
                <SwitchLogView 
                    v-model="logView"
                    :value-left="'calendar'" 
                    :value-right="'list'"
                    :icon-left="CalendarDays"
                    :icon-right="List"
                    class="switch-log-view float-right ml-2 text-gray-500"
                />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 font-bold text-xl">
            <div class="flex items-center gap-2 m-2 p-8 rounded-xl bg-red-100">
                <Flame :size="36" class="text-amber-500" />
                <div>
                    <div v-if="props.currentStreak === 1">{{ props.currentStreak }} Day</div>
                    <div v-else>{{ props.currentStreak }} Days</div>
                    <div class="font-normal text-sm">Current Streak</div>
                </div>
            </div>  
            <div class="flex items-center gap-2 m-2 p-8 rounded-xl bg-amber-100">
                <Flame :size="36" class="text-amber-500" />
                <div>
                    <div v-if="props.longestStreak === 1">{{ props.longestStreak }} Day</div>
                    <div v-else>{{ props.longestStreak }} Days</div>
                    <div class="font-normal text-sm">Longest Streak</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-left"><h2>{{ monthNames[currentMonth.month] }} {{ currentMonth.year }}</h2></div>
            <div class="text-right">
                <Button class="btn" variant="outline" size="icon" title="Previous Month" @click="previousMonth">
                    <ChevronLeft />
                </Button>
                <Button class="btn" variant="outline" size="icon" title="Next Month" @click="nextMonth">
                    <ChevronRight />
                </Button>
            </div>
        </div>

        <div>
            <ReadingLogCalendarView 
                v-if="logView === 'calendar'" 
                :current-month="currentMonth"
                :entries="props.entries"
            />

            <ReadingLogListView v-else-if="logView === 'list'" :current-month="currentMonth" :entries="props.entries" />
        </div>
    </div>
</template>

<style scoped>

</style>
