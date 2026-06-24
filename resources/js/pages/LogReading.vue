<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import LogEntry from '@/components/LogReading/LogEntry.vue';
import SelectTitle from '@/components/LogReading/SelectTitle.vue';
import { logReading } from '@/routes';
import type { BookSearchResult } from '@/types/reading-log';

const step = ref(1);
const selectedBook = ref<BookSearchResult | null>(null);

const handleBookSelect = (book: BookSearchResult) => {
    selectedBook.value = book;
    step.value = 2;
};

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Log Reading',
                href: logReading(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Log Reading" />

    <div
        class="p-4 border-b border-gray-200"
    >
        <div class="text-left"><h1>Log Reading</h1></div>
    </div>

    <SelectTitle v-if="step === 1" @select="handleBookSelect" />

    <LogEntry v-if="step === 2" :book="selectedBook" />
</template>
