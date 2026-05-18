<script setup lang="ts" generic="T = string">
import { cn } from '@/lib/utils';
import type { Component } from 'vue'

// Define the model for two-way binding
const modelValue = defineModel<T>()

// Define props for values and Lucide icon components
const props = defineProps<{
  valueLeft: T
  valueRight: T
  iconLeft?: Component
  iconRight?: Component
}>()
</script>

<template>
  <div :class="cn('border-1 rounded-md flex')">
    <!-- Left Button -->
    <button 
      type="button" 
      @click="modelValue = props.valueLeft"
      class="p-1"
      :class="{ 'bg-gray-100': modelValue == props.valueLeft }"
    >
      <slot name="left">
        <component :is="props.iconLeft" v-if="props.iconLeft" />
        <template v-else>Left</template>
      </slot>
    </button>

    <!-- Right Button -->
    <button 
      type="button" 
      @click="modelValue = props.valueRight"
      class="p-1"
      :class="{ 'bg-gray-100': modelValue == props.valueRight }"
    >
      <slot name="right">
        <component :is="props.iconRight" v-if="props.iconRight" />
        <template v-else>Right</template>
      </slot>
    </button>
  </div>
</template>
