<template>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-6">Available Rooms</h1>

      <div v-if="rooms && rooms.data.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <!-- Room Card -->
          <div
            v-for="room in rooms.data"
            :key="room.id"
            class="rounded-2xl border bg-card p-6 shadow-sm transition-shadow hover:shadow-lg"
          >
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold">{{ room.name }}</h2>
              <span
                v-if="room.is_reserved"
                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700"
              >
                Reserved
              </span>
            </div>

            <div class="text-sm text-muted-foreground space-y-1">
              <p>Price: <span class="font-medium text-foreground">${{ (room.price / 100).toFixed(2) }}</span></p>
              <p>Capacity: <span class="font-medium text-foreground">{{ room.capacity }} persons</span></p>
            </div>

            <div v-if="!room.is_reserved" class="mt-6">
              <button
                @click="goToReservation(room.id)"
                class="w-full bg-primary text-white py-2 rounded-md hover:bg-primary/90 transition"
              >
                Make Reservation
              </button>
            </div>
          </div>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-8 flex justify-center gap-4">
          <button
            v-if="rooms.links.prev"
            @click="changePage(rooms.links.prev)"
            class="px-5 py-2 text-sm font-semibold rounded-md bg-primary text-white hover:bg-primary/90"
          >
            Previous
          </button>
          <button
            v-if="rooms.links.next"
            @click="changePage(rooms.links.next)"
            class="px-5 py-2 text-sm font-semibold rounded-md bg-primary text-white hover:bg-primary/90"
          >
            Next
          </button>
        </div>
      </div>

      <div v-else class="text-center mt-12">
        <p class="text-muted-foreground">No available rooms at the moment.</p>
      </div>
    </div>
  </template>

  <script setup>
  import { usePage } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';

  const { rooms } = usePage().props;

  const changePage = (url) => {
    Inertia.visit(url);
  };

  const goToReservation = (roomId) => {
    console.log('Navigating to reservation for room:', roomId);
    window.location.href = `/client/reservations/rooms/${roomId}`;
  };
  </script>
