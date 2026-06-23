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
                <div class="flex gap-4 border-b border-gray-200 pb-6 mb-8"> 
                    <div class="w-3/4">
                        <div class="font-bold">Log reading for:</div>
                    </div>
                    <div class="w-1/4 flex justify-end">
                        <div>
                            <Popover>
                                <PopoverTrigger as-child>
                                <Button
                                    variant="outline"
                                    :class="cn(
                                    'w-70 justify-start text-left font-normal',
                                    !date && 'text-muted-foreground',
                                    )"
                                >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    {{ date ? formatter.format(date.toDate(getLocalTimeZone())) : "Pick a date" }}
                                </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-auto p-0">
                                <Calendar
                                    v-model="date"
                                    :initial-focus="true"
                                    :default-placeholder="defaultPlaceholder"
                                    layout="month-and-year"
                                />
                                </PopoverContent>
                            </Popover>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 items-start"> 
                    <div class="w-3/4">
                        <div class="font-bold">Time spent reading:</div>
                    </div>
                    <div class="w-1/4 flex justify-end">
                        <Button variant="default" class="bg-rose-200 hover:bg-rose-300 text-lg text-rose-700 cursor-pointer">
                            <Timer />
                            Start Timer
                        </Button>
                    </div>
                </div>

                <div class="flex gap-4 border-b border-gray-200 pb-6 mb-8"> 
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
                    <div class="w-1/4 flex justify-end">
                        <Button variant="default" class="bg-rose-500 hover:bg-rose-700 text-lg cursor-pointer">
                            Log Reading
                        </Button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import { DateFormatter, getLocalTimeZone, today  } from '@internationalized/date'
import type {CalendarDate} from '@internationalized/date';
import { Timer, CalendarIcon } from 'lucide-vue-next'
import { ref } from 'vue';
import { Calendar } from '@/components/ui/calendar'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { cn } from '@/lib/utils'
import type { BookSearchResult } from '@/types/reading-log';
import Button from '../ui/button/Button.vue';

defineProps<{
    book: BookSearchResult | null;
}>();

const date = ref<CalendarDate>()
const formatter = new DateFormatter('en-US', { dateStyle: 'full' })
const defaultPlaceholder = today(getLocalTimeZone())
</script>