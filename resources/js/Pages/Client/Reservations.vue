<script setup>
import { usePage } from '@inertiajs/vue3';
import  DataTable  from '@/components/ui/data-table.vue'; // shadcn Vue DataTable

// Get reservations from the page props
const { reservations } = usePage().props;
console.log(reservations);

// Define table columns
const columns = [
  { name: 'Room Number', field: 'room.number' },
  { name: 'Accompany Number', field: 'accompany_number' },
  {
    name: 'Paid Price',
    field: 'paid_price',
    formatter: (value) => `$${(value / 100).toFixed(2)}`, // Convert cents to dollars
  }
];
</script>

<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">My Reservations</h1>

    <DataTable
     v-if="reservations && reservations.data"
      :columns="columns"
      :data="reservations.data"
      :meta="reservations.meta || {}"
      :links="reservations.links || {}"
      manualPagination
    />
    <div v-else>
      <p>Loading reservations...</p>
    </div>
  </div>
</template>
