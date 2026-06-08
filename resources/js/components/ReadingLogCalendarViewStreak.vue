<template>
    <template v-if="isStreakStart">
        <div>
            <div 
                class="py-2 bg-orange-200 rounded-l-lg ml-4 border-l-6 border-l-orange-500"
                :class="{ 'hidden': day.entries.length === 0 }"
            >
                &nbsp;
            </div>
        </div>
    </template>

    <template v-else-if="isStreakEnd">
        <div>
            <div 
                class="py-2 bg-orange-200 rounded-r-lg mr-4 flex justify-end relative z-10"
                :class="{ 'hidden': day.entries.length === 0 }"
            >
                <span 
                    class="text-orange-600 font-bold text-sm relative mr-2"
                    style="top: 2px;"
                >
                    {{ streakLength }}
                </span>
                <Flame :size="24" class="text-amber-500 mr-2" />
            </div>
        </div>
    </template>

    <template v-else>
        <div 
            class="py-2 bg-orange-200 relative z-10"
            :class="{ 'hidden': day.entries.length === 0 }"
        >
            &nbsp;
        </div>
    </template>
</template> 

<script setup lang="ts">
import { Flame } from 'lucide-vue-next';
import { computed } from 'vue';
import type { ReadingLogDay, ReadingLogWeek} from '@/types';

declare global {
    interface Window {
        __STINT_RLCV_STREAK_COUNTER?: number;
    }
}

const props = defineProps<{
    previousDay: ReadingLogDay;
    day: ReadingLogDay;
    dayIndex: number;
    nextDay: ReadingLogDay;
    previousWeek: ReadingLogWeek;
    nextWeek: ReadingLogWeek;
}>();

const isStreakStart = computed(() => {
    const dayHasEntries = props.day.entries.length > 0;
    const previousDay = props.dayIndex === 0 ? props.previousWeek.days[6] : props.previousDay;
    const previousDayHasEntries = previousDay.entries.length > 0;

    return dayHasEntries && !previousDayHasEntries;
});

const isStreakEnd = computed(() => {
    const dayHasEntries = props.day.entries.length > 0;
    const nextDay = props.dayIndex === 6 ? props.nextWeek.days[0] : props.nextDay;
    const nextDayHasEntries = nextDay?.entries.length > 0;

    return dayHasEntries && !nextDayHasEntries;
});

const streakLength = computed(() => {
    const len = window.__STINT_RLCV_STREAK_COUNTER ?? 0;

    return `${len} day streak`;
});

if (isStreakStart.value) {
    window.__STINT_RLCV_STREAK_COUNTER = 1;
} else {
    window.__STINT_RLCV_STREAK_COUNTER = (window.__STINT_RLCV_STREAK_COUNTER ?? 0) + 1;
}

</script>

<style scoped>

</style>