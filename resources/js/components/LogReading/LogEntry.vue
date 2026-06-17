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
                    <div>
                        info
                    </div>
                </div>
            </div>
            
            <div class="w-3/5 rounded-xl bg-gray-100 p-4 text-left">
                log settings
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import type { BookSearchResult } from '@/types/reading-log';

defineProps<{
    book: BookSearchResult | null;
}>();
</script>