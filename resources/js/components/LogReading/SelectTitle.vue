<template>
    <div class="text-center w-full px-2 md:w-1/2 mx-auto">
        <h2 class="my-4">Select A Title</h2>

        <div class="rounded-xl p-4 bg-gray-50">
            <div>
                <Popover :open="isPopoverOpen && searchResults.length > 0" @update:open="(val) => isPopoverOpen = val">
                    <PopoverTrigger as-child>
                        <div class="relative w-full max-w-md mx-auto mt-4">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                            <Input 
                                type="text" 
                                placeholder="Search by title or author..." 
                                class="w-full bg-white pl-10 pr-10 md:text-lg"
                                v-model="searchQuery"
                                @input="search"
                            />
                            <Loader2 v-if="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 animate-spin text-gray-400" />
                        </div>
                    </PopoverTrigger>
                    <PopoverContent class="w-full max-w-md max-h-60 overflow-y-auto p-0">
                    <div class="grid p-0">
                        <div v-for="(result, resultIndex) in searchResults" :key="resultIndex" @click="selectResult(result)">
                            <div class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 cursor-pointer">
                                <img :src="'/book-cover?id=' + result.cover_edition_key" alt="Book Cover" class="w-12 h-18 object-cover rounded shrink-0">
                                <div class="flex-1 min-w-0 text-left">
                                    <div class="font-bold truncate">
                                        {{ result.title }}
                                        <template v-if="result.subtitle">
                                            ({{ result.subtitle }})
                                        </template>
                                    </div>
                                    <div class="text-sm text-gray-500 truncate">{{ result.author_name ? result.author_name.join(', ') : 'Unknown Author' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    </PopoverContent>
                </Popover>
            </div>
            <div>
                <Button 
                    @click="manuallyEnterTitle" 
                    class="mt-4 text-lg text-gray-500 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 border border-gray-300"
                >
                    <Pencil />
                    Manually Enter Title
                </Button>
            </div>
        </div>

        <div class="rounded-xl p-4 bg-gray-50 mt-8">
            x
        </div>
    </div>
</template> 

<script setup lang="ts">
import { Pencil, Loader2, Search } from 'lucide-vue-next'
import { ref } from 'vue';
import Input from '@/components/ui/input/Input.vue';
import type { BookSearchResult } from '@/types/reading-log';
import Button from '../ui/button/Button.vue';
import Popover from '../ui/popover/Popover.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';

const emit = defineEmits<{
    select: [book: BookSearchResult|null];
}>();

let searchTimeout: number;
let abortController: AbortController | null = null;

const searchQuery = ref('');
const searchResults = ref<BookSearchResult[]>([]);
const isPopoverOpen = ref(false);
const isSearching = ref(false);

const selectResult = (book: BookSearchResult) => {
    emit('select', book);
    searchQuery.value = '';
    searchResults.value = [];
    isPopoverOpen.value = false;
};

const manuallyEnterTitle = () => {
    emit('select', null);
    searchQuery.value = '';
    searchResults.value = [];
    isPopoverOpen.value = false;
};

const search = () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    abortController?.abort();

    searchTimeout = setTimeout(async () => {
        if (searchQuery.value.trim().length <= 3) {
            return;
        }

        abortController = new AbortController();
        const signal = abortController.signal;

        searchResults.value = [];
        isSearching.value = true;

        try {
            const response = await fetch('/book-search?q=' + encodeURIComponent(searchQuery.value), { signal });

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            searchResults.value = data.data.docs.map((doc: any) => ({
                title: doc.title,
                author_name: doc.author_name,
                cover_edition_key: doc.cover_edition_key,
                subtitle: doc?.subtitle,
                olid: doc?.olid,
            }));

            isPopoverOpen.value = searchResults.value.length > 0;
        } catch (error) {
            if (error instanceof DOMException && error.name === 'AbortError') {
                return;
            }
        } finally {
            isSearching.value = false;
        }
    }, 500);
}
</script>
