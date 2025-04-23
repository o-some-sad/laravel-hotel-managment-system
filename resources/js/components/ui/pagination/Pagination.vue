<script setup>
import { PaginationRoot } from 'radix-vue'

defineProps({
  links: Array
})
</script>

<template>
  <nav class="flex justify-center">
    <PaginationRoot class="flex gap-1">
      <template v-for="(link, index) in links" :key="index">
        <component
          :is="link.url ? 'a' : 'span'"
          :href="link.url"
          class="px-3 py-2 border rounded"
          :class="{ 'bg-gray-100': link.active }"
          v-html="link.label"
        />
      </template>
    </PaginationRoot>
  </nav>
</template>