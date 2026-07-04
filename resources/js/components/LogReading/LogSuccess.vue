<template>
    <div class="text-center w-full px-2 md:w-3/4 mx-auto">
        <div class="rounded-xl bg-gray-100 dark:bg-neutral-800 p-8 text-center">
            <div class="flex justify-center mb-4">
                <CheckCircle class="w-16 h-16 text-green-500" />
            </div>
            <h2 class="my-2">Reading logged successfully!</h2>
            <p class="text-gray-500 dark:text-neutral-400 mb-6">Keep up the great reading habit.</p>
            <div class="flex gap-4 justify-center">
                <Button
                    variant="default"
                    class="bg-rose-500 hover:bg-rose-700 text-lg cursor-pointer"
                    @click="emit('anotherLog')"
                >
                    Log Another
                </Button>
                <Button
                    variant="outline"
                    class="text-lg cursor-pointer"
                    @click="emit('viewLog')"
                >
                    View Log
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { CheckCircle } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';

const emit = defineEmits(['anotherLog', 'viewLog']);
</script>