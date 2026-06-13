<template>
    <div class="text-center w-full px-2 md:w-1/2 mx-auto">
        <h2 class="my-4">Select A Title</h2>

        <div class="rounded-xl p-4 bg-gray-50">
            <div>
                <Popover :open="isPopoverOpen && searchResults.length > 0" @update:open="(val) => isPopoverOpen = val">
                    <PopoverTrigger as-child>
                        <div>
                            <Input 
                                type="text" 
                                placeholder="Search by title or author..." 
                                class="w-full max-w-md mx-auto mt-4 bg-white"
                                v-model="searchQuery"
                                @keyup="search"
                            />
                        </div>
                    </PopoverTrigger>
                    <PopoverContent class="w-80">
                    <div class="grid p-2">
                        {{ searchResults }}
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
import { Pencil } from 'lucide-vue-next'
import { ref } from 'vue';
import Input from '@/components/ui/input/Input.vue';
import Button from '../ui/button/Button.vue';
import Popover from '../ui/popover/Popover.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';

let searchTimeout: number;

const searchQuery = ref('');
const searchResults = ref('');
const isPopoverOpen = ref(false);

const search = () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(async () => {
        if(searchQuery.value.trim().length > 3) {
            console.log('Searching for:', searchQuery.value);
            const response = await fetch('/book-search?q=' + encodeURIComponent(searchQuery.value));
            const data = await response.json();

            searchResults.value = data.message;
            isPopoverOpen.value = true;
            console.log('Search results:', data);
        }
    }, 250);
}
</script>
