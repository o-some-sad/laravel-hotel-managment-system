<template>
    <div class="p-8">
      <!-- Title -->
      <h1 class="text-2xl font-bold mb-6">My Reservations</h1>

      <!-- Success and Error Alerts -->
      <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
        {{ successMessage }}
      </div>
      <div v-if="errorMessage" class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
        {{ errorMessage }}
      </div>

      <!-- Data Table -->
      <div v-if="bookings && bookings.data.length > 0" class="rounded-2xl border bg-card shadow-sm">
        <table class="w-full table-auto text-left">
          <thead class="bg-muted/50 text-muted-foreground">
            <tr>
              <th class="p-4">Room #</th>
              <th class="p-4">Accompany Number</th>
              <th class="p-4">Paid Price</th>
              <th class="p-4">Payment Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in bookings.data" :key="row.id" class="border-t hover:bg-muted/10 transition">
              <td class="p-4 font-medium">#{{ row.room.number }}</td>
              <td class="p-4">{{ row.accompany_number }}</td>
              <td class="p-4">${{ (row.paid_price / 100).toFixed(2) }}</td>
              <td class="p-4">
                <Badge :class="getStatusColor(row.payment_status)">
                  {{ row.payment_status }}
                </Badge>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination Controls -->
      <div class="mt-8 flex justify-center gap-4" v-if="bookings.meta">
        <button
          v-if="bookings.links.prev"
          @click="changePage(bookings.links.prev)"
          class="px-5 py-2 text-sm font-semibold rounded-md bg-primary text-white hover:bg-primary/90"
        >
          Previous
        </button>
        <button
          v-if="bookings.links.next"
          @click="changePage(bookings.links.next)"
          class="px-5 py-2 text-sm font-semibold rounded-md bg-primary text-white hover:bg-primary/90"
        >
          Next
        </button>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center mt-12">
        <p class="text-muted-foreground">You have no reservations yet.</p>
      </div>
    </div>
  </template>

  <script setup>
  import { usePage, router } from '@inertiajs/vue3';
  import { onMounted } from 'vue';
  import { Badge } from '@/components/ui/badge';

  // Get data from props
  const { bookings } = usePage().props;

  const urlParams = new URLSearchParams(window.location.search);
  const successMessage = urlParams.get('success');
  const errorMessage = urlParams.get('error');

  onMounted(() => {
    if (successMessage || errorMessage) {
      setTimeout(() => {
        router.replace({ query: {} });
      }, 5000);
    }
  });

  // Payment Status Badge Color Logic
  const getStatusColor = (status) => {
    switch (status.toLowerCase()) {
      case 'paid':
        return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
      case 'pending':
      case 'unpaid':
        return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
      case 'refunded':
      case 'cancelled':
        return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
      default:
        return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
    }
  };

  // Pagination Handler
  const changePage = (url) => {
    router.visit(url);
  };
  </script>
