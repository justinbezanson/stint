<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { logReading } from '@/routes';

const props = defineProps<{
    test: string;
}>();

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
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        Log Reading {{ props.test }}
    </div>
</template>
