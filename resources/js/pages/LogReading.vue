<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import LogEntry from '@/components/LogReading/LogEntry.vue';
import SelectTitle from '@/components/LogReading/SelectTitle.vue';
import { logReading } from '@/routes';

// const props = defineProps<{
//     test: string;
// }>();

const step = ref(1);

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

    <SelectTitle v-if="step === 1" />

    <LogEntry v-if="step === 2" />
</template>
