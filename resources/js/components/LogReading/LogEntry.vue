<template>
    <div class="text-center w-full px-2 md:w-3/4 mx-auto">
        <h2 class="my-4">Log Your Reading</h2>
        <div class="flex">
            <div class="w-2/5 rounded-xl bg-gray-100 text-left mr-4">
                <div class="md:flex p-4">
                    <img 
                        :src="bookCoverSrc" 
                        alt="Book Cover"
                        class="w-25 mx-auto md:mx-0 border border-gray-200"
                    >
                    <div v-if="props.book !== null" class="pl-4">
                        <div class="font-bold">{{ props.book.title}}</div>
                        <div v-if="props.book.subtitle" class="text-sm">{{ props.book.subtitle }}</div>
                        <div class="text-sm text-gray-500">
                            <span v-if="props.book.author_name">{{ props.book.author_name.join(', ') }}</span>
                        </div>
                    </div>
                    <div v-else class="pl-4">
                        <div>
                            <Input v-model="form.title" class="md:text-lg bg-white mt-2" placeholder="Enter title" />
                        </div>
                        <div>
                            <Input v-model="form.author" class="md:text-lg bg-white mt-2" placeholder="Enter author" />
                        </div>
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
                        
                    </div>
                </div>

                <div class="flex gap-4 border-b border-gray-200 pb-6 mb-8"> 
                    <div class="w-3/4">
                        <div>
                            <Input 
                                v-model="form.duration" 
                                class="md:text-lg bg-white mt-2" 
                                placeholder="Type &quot;1h&quot;, &quot;30m&quot;, or &quot;1h30m&quot;" 
                            />
                        </div>
                    </div>
                    <div class="w-1/4">
                        
                    </div>
                </div>

                <div class="flex gap-4"> 
                    <div class="w-3/4">
                        <div>&nbsp;</div>
                    </div>
                    <div class="w-1/4 flex justify-end">
                        <Button 
                            variant="default" 
                            class="bg-rose-500 hover:bg-rose-700 text-lg cursor-pointer"
                            @click="logReading"
                            :disabled="!selectedDate || !form.duration || logReadingDisabled"
                        >
                            Log Reading
                        </Button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { DateFormatter, getLocalTimeZone, today  } from '@internationalized/date'
import { CalendarDate } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue';
import { Calendar } from '@/components/ui/calendar'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { cn } from '@/lib/utils'
import type { BookSearchResult } from '@/types/reading-log';
import Button from '../ui/button/Button.vue';
import Input from '../ui/input/Input.vue';

const emit = defineEmits<{
    saved: []
}>();

const props = defineProps<{
    book: BookSearchResult | null;
}>();

const t = new Date();
const date = ref<CalendarDate>(new CalendarDate(t.getFullYear(), t.getMonth() + 1, t.getDate()));
const formatter = new DateFormatter('en-US', { dateStyle: 'full' })
const defaultPlaceholder = today(getLocalTimeZone())
const logReadingDisabled = ref(false);

const selectedDate = computed(() => {
    return date.value.toDate(getLocalTimeZone()).toISOString().split('T')[0]
})

const bookCoverSrc = computed(() => {
    if (! props.book || props.book === null) {
        return '';
    }

    return `/book-cover?id=${props.book?.cover_edition_key}&size=M`
})

const form = useForm({
    logDate: selectedDate.value,
    duration: '',
    title: props.book?.title ?? '',
    subtitle: props.book?.subtitle ?? '',
    author: props.book?.author_name?.join(', ') ?? '',
    cover_edition_key: props.book?.cover_edition_key ?? null,
    book_id: props.book !== null ? props.book.key : '',
})

const logReading = () => {
    form.logDate = selectedDate.value;

    logReadingDisabled.value = true;
    form.post('/create-entry', {
        onSuccess: () => {
            form.reset();
            emit('saved');
        },

        onError: () => {
            console.log('error');
        },

        onFinish: () => {
            logReadingDisabled.value = false;
        }
    })
}
</script>