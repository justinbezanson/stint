<template>
    <div class="text-center w-full px-2 md:w-1/2 mx-auto">
        <h2 class="my-4">Select A Title</h2>

        <div class="rounded-xl p-4 bg-gray-50">
            <div>
                <Popover :open="isPopoverOpen && searchResults.length > 0" @update:open="(val) => isPopoverOpen = val">
                    <PopoverTrigger as-child>
                        <div class="relative w-full max-w-md mx-auto mt-4">
                            <Input 
                                type="text" 
                                placeholder="Search by title or author..." 
                                class="w-full bg-white pr-10"
                                v-model="searchQuery"
                                @keyup="search"
                            />
                            <Loader2 v-if="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 animate-spin text-gray-400" />
                        </div>
                    </PopoverTrigger>
                    <PopoverContent class="w-full max-w-md max-h-60 overflow-y-auto p-0">
                    <div class="grid p-0">
                        <div v-for="(result, resultIndex) in searchResults" :key="resultIndex">
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
                <Button class="btn mt-4 bg-orange-200 hover:bg-orange-100 border-orange-300" variant="outline">
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
import { Pencil, Loader2 } from 'lucide-vue-next'
import { ref } from 'vue';
import Input from '@/components/ui/input/Input.vue';
import type { BookSearchResult } from '@/types/reading-log';
import Button from '../ui/button/Button.vue';
import Popover from '../ui/popover/Popover.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';

let searchTimeout: number;

const searchQuery = ref('');
const searchResults = ref<BookSearchResult[]>([]);
const isPopoverOpen = ref(false);
const isSearching = ref(false);

const search = () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(async () => {
        if(searchQuery.value.trim().length > 3) {
            searchResults.value = [];
            isSearching.value = true;
            const response = await fetch('/book-search?q=' + encodeURIComponent(searchQuery.value));
            const data = await response.json();

            isSearching.value = false;

            searchResults.value = data.data.docs.map((doc: any) => ({
                title: doc.title,
                author_name: doc.author_name,
                cover_edition_key: doc.cover_edition_key
            }));

            isPopoverOpen.value = true;
        }
    }, 500);

    /*
"data": {
        "numFound": 12,
        "start": 0,
        "numFoundExact": true,
        "num_found": 12,
        "documentation_url": "https:\/\/openlibrary.org\/dev\/docs\/api\/search",
        "q": "path of daggers",
        "offset": null,
        "docs": [
            {
                "author_key": [
                    "OL233594A"
                ],
                "author_name": [
                    "Robert Jordan"
                ],
                "cover_edition_key": "OL374119M",
                "cover_i": 182462,
                "ebook_access": "borrowable",
                "edition_count": 32,
                "first_publish_year": 1998,
                "has_fulltext": true,
                "ia": [
                    "bizhidao0002qiao",
                    "pathofdaggerswhe00robe",
                    "pathofdaggers0000jord",
                    "pathofdaggers00jord",
                    "pathofdaggers00jord"
                ],
                "ia_collection": [
                    "americana",
                    "delawarecountydistrictlibrary",
                    "inlibrary",
                    "internetarchivebooks",
                    "popularchinesebooks",
                    "printdisabled"
                ],
                "key": "\/works\/OL1946687W",
                "language": [
                    "eng",
                    "chi"
                ],
                "lending_edition_s": "OL28153817M",
                "lending_identifier_s": "bizhidao0002qiao",
                "public_scan_b": false,
                "subtitle": "(The Wheel of Time, Book 8)",
                "title": "The Path of Daggers"
            },
    */
}
</script>
