<template>
    <div class="text-center w-full px-2 md:w-3/4 mx-auto">
        <h2 class="my-4">Log Your Reading</h2>
        <div class="flex">
            <div class="w-2/5 rounded-xl bg-gray-100 text-left mr-4">
                <div class="md:flex p-4">
                    <img 
                        :src="'http://localhost:8000/book-cover?id=OL10738416M&size=M'" 
                        alt="Book Cover"
                        class="w-25 mx-auto md:mx-0"
                    >
                    <div class="pl-4">
                        <div class="font-bold">The Wheel Of Time</div>
                        <div class="text-sm text-gray-500">Robert Jordan</div>
                    </div>
                </div>
            </div>
            
            <div class="w-3/5 rounded-xl bg-gray-100 p-4 text-left">
                <div class="flex gap-4"> 
                    <div class="w-3/4">
                        <div>Log reading for:</div>
                    </div>
                    <div class="w-1/4">
                        <div>Some data here</div>
                    </div>
                </div>

                <div class="flex gap-4"> 
                    <div class="w-3/4">
                        <div>Time spent reading:</div>
                    </div>
                    <div class="w-1/4">
                        <Button variant="default" class="bg-rose-200 hover:bg-rose-300 text-lg text-rose-700">
                            <Timer />
                            Start Timer
                        </Button>
                    </div>
                </div>

                <div class="flex gap-4"> 
                    <div class="w-3/4">
                        <div>&nbsp;</div>
                    </div>
                    <div class="w-1/4">
                        <div>Some data here</div>
                    </div>
                </div>

                <div class="flex gap-4"> 
                    <div class="w-3/4">
                        <div>&nbsp;</div>
                    </div>
                    <div class="w-1/4">
                        <Button variant="default" class="bg-rose-500 hover:bg-rose-700 text-lg">
                            Log Reading
                        </Button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import { Timer } from 'lucide-vue-next'
import type { BookSearchResult } from '@/types/reading-log';
import Button from '../ui/button/Button.vue';

defineProps<{
    book: BookSearchResult | null;
}>();
</script>