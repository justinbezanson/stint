<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black/30 z-50"
        v-bind="$attrs"
    >
        <div class="rounded-lg bg-white p-6 flex items-center justify-center">
        <Loader class="w-8 h-8 text-sky-500 animate-spin [animation-duration:2s]" />
        </div>
    </div>
</template> 

<script lang="ts" setup>
import { Loader } from 'lucide-vue-next';
</script>