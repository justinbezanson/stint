<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import LogEntry from '@/components/LogReading/LogEntry.vue';
import LogSuccess from '@/components/LogReading/LogSuccess.vue';
import SelectTitle from '@/components/LogReading/SelectTitle.vue';
import { logReading } from '@/routes';
import type { BookSearchResult } from '@/types/reading-log';

const step = ref(1);
const selectedBook = ref<BookSearchResult | null>(null);

const handleBookSelect = (book: BookSearchResult) => {
    selectedBook.value = book;
    step.value = 2;
};

const handleEntrySaved = () => {
    step.value = 3;
    selectedBook.value = null;
};

const handleViewLog = () => {
    router.get('/dashboard');
}

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

    <LogEntry v-if="step === 2" :book="selectedBook" @saved="handleEntrySaved" />

    <LogSuccess v-if="step === 3" @anotherLog="step = 1" @viewLog="handleViewLog" />
</template>
