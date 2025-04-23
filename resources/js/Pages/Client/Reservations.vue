<script setup>
import { usePage } from '@inertiajs/vue3';
import DataTable from '@/components/ui/data-table.vue'; // shadcn DataTable
import { Badge } from '@/components/ui/badge';
import { Calendar, Hotel, ArrowRight } from 'lucide-vue-next';
import { h } from 'vue';

// Get bookings from page props
const { bookings } = usePage().props;

// Status color function
const getStatusColor = (status) => {
  switch (status) {
    case 'Confirmed':
      return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
    case 'Pending':
      return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
    case 'Cancelled':
      return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    default:
      return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
  }
};

// No need to define normal columns because we’ll use a custom row slot
</script>

<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">My Reservations</h1>

    <DataTable
      v-if="bookings && bookings.data"
      :data="bookings.data"
      :meta="bookings.meta || {}"
      :links="bookings.links || {}"
      manualPagination
    >
      <template #row="{ row }">
        <div class="rounded-lg border p-4 mb-4 bg-card shadow-sm">
          <div class="grid gap-4 md:grid-cols-[1fr_auto]">
            <div class="grid gap-1">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <Hotel class="h-4 w-4 text-primary" />
                  <span class="font-semibold">{{ row.room.name }}</span>
                </div>
                <Badge :class="getStatusColor(row.status)">
                  {{ row.status }}
                </Badge>
              </div>
              <div class="text-sm text-muted-foreground mt-1">Reservation ID: {{ row.id }}</div>
              <div class="flex items-center gap-2 mt-2">
                <Calendar class="h-4 w-4 text-muted-foreground" />
                <span class="text-sm">{{ row.check_in }}</span>
                <ArrowRight class="h-3 w-3 text-muted-foreground" />
                <span class="text-sm">{{ row.check_out }}</span>
              </div>
              <div class="font-medium mt-2">{{ (row.paid_price / 100).toFixed(2) }} USD</div>
            </div>
            <div class="flex items-center gap-2 self-end">
              <button
                v-if="row.status !== 'Cancelled'"
                class="px-3 py-1 text-sm rounded-md border hover:bg-primary/10"
              >
                Modify
              </button>
              <button
                v-if="row.status !== 'Cancelled'"
                class="px-3 py-1 text-sm rounded-md bg-red-100 text-red-700 hover:bg-red-200"
              >
                Cancel
              </button>
              <button
                v-if="row.status === 'Cancelled'"
                class="px-3 py-1 text-sm rounded-md border hover:bg-primary/10"
              >
                Book Again
              </button>
            </div>
          </div>
        </div>
      </template>
    </DataTable>

    <div v-else>
      <p>Loading reservations...</p>
    </div>
  </div>
</template>
