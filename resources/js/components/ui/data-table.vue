<script setup>
import { computed } from 'vue';

const props = defineProps({
  data: {
    type: Array,
    required: true
  },
  meta: {
    type: Object,
    default: () => ({})
  },
  links: {
    type: Object,
    default: () => ({})
  },
  manualPagination: {
    type: Boolean,
    default: false
  }
});

// Example: get current page
const currentPage = computed(() => props.meta.current_page || 1);
</script>

<template>
  <div>
    <p>Page: {{ currentPage }}</p>
    <div v-for="item in props.data" :key="item.id" class="border p-4 my-2">
      <!-- Render something -->
      <pre>{{ item }}</pre>
    </div>
  </div>
</template>
