<template>
    List View {{ props.currentMonth.month + 1 }} {{ props.currentMonth.year }}
</template>

<script setup lang="ts">
import type { ReadingLogMonth } from '@/types';

const props = defineProps<{
    currentMonth: ReadingLogMonth;
}>();
</script>

<style scoped>

</style>