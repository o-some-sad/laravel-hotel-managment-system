<script setup>
import { ref, watch } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

defineProps({
  columns: Array,
  data: Array,
  meta: Object,
  links: Object,
  manualPagination: Boolean,
});

const emit = defineEmits(['page-change']);

const currentPage = ref(1);

watch(() => meta?.current_page, (val) => {
  if (val) currentPage.value = val;
});

const goToPage = (page) => {
  if (page < 1 || page > meta.last_page) return;
  emit('page-change', page);
};
</script>

<template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800">
      <thead class="border-b dark:border-gray-700">
        <tr>
          <th v-for="col in columns" :key="col.field" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ col.name }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y dark:divide-gray-700">
        <tr v-for="item in data" :key="item.id">
          <td v-for="col in columns" :key="col.field" class="px-6 py-4 whitespace-nowrap">
            {{ col.formatter ? col.formatter(getNestedValue(item, col.field)) : getNestedValue(item, col.field) }}
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if="manualPagination && meta" class="flex items-center justify-between mt-4 px-6">
      <button
        @click="goToPage(meta.current_page - 1)"
        :disabled="meta.current_page <= 1"
        class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 disabled:opacity-50"
      >
        <ChevronLeft class="h-4 w-4" />
      </button>

      <span class="text-gray-600 dark:text-gray-300">
        Page {{ meta.current_page }} of {{ meta.last_page }}
      </span>

      <button
        @click="goToPage(meta.current_page + 1)"
        :disabled="meta.current_page >= meta.last_page"
        class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 disabled:opacity-50"
      >
        <ChevronRight class="h-4 w-4" />
      </button>
    </div>
  </div>
</template>

<script>
// Helper function to access nested object fields (e.g., "room.number")
function getNestedValue(obj, path) {
  return path.split('.').reduce((o, p) => (o ? o[p] : ''), obj);
}
</script>
