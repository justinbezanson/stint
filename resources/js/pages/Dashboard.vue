<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { CalendarDays, List } from 'lucide-vue-next'
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import SwitchLogView from '@/components/ui/switch-log-view/SwitchLogView.vue';
import { dashboard } from '@/routes';

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

const logView = ref('calendar');

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

        <p>Log view: {{ logView }}</p>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-center border-1 m-2 p-8 rounded-lg">Current Streak</div>
            <div class="text-center border-1 m-2 p-8 rounded-lg">Longest Streak</div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-left"><h2>Month</h2></div>
            <div class="text-right">Nav</div>
        </div>
    </div>
</template>

<style scoped>

</style>
