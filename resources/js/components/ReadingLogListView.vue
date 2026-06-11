<template>
    <div>
        <div v-for="week in weekRows" :key="week.week" class="">
            Week range
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { ReadingLogMonth, GroupedReadingLogEntries, ReadingLogWeek } from '@/types';
import { useReadingLogWeeks } from '../composables/useReadingLogWeeks';

const props = defineProps<{
    currentMonth: ReadingLogMonth;
    entries: GroupedReadingLogEntries;
    isLoading: boolean;
}>();

const weekRows = computed<ReadingLogWeek[]>(() => useReadingLogWeeks(props.entries, props.currentMonth));
</script>

<style scoped>

</style>