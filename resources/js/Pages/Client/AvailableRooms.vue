<template>
    <div class="p-8">
      <h1 class="text-2xl font-bold mb-4">Available Rooms</h1>

      <!-- Check if rooms data is available -->
      <div v-if="rooms && rooms.data.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <!-- Loop through available rooms -->
          <div v-for="room in rooms.data" :key="room.id" class="border p-4 rounded-lg">
            <h2 class="text-lg font-semibold">{{ room.name }}</h2>
            <p>Price: ${{ (room.price / 100).toFixed(2) }}</p>
            <p>Capacity: {{ room.capacity }}</p>
            <p v-if="room.is_reserved" class="text-red-500">This room is already reserved.</p>

            <!-- Make Reservation button (visible if room is not reserved) -->
            <div v-else>
              <button
                @click="goToReservation(room.id)"
                class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700 mt-4"
              >
                Make Reservation
              </button>
            </div>
          </div>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-between">
          <button
            v-if="rooms.links.prev"
            @click="changePage(rooms.links.prev)"
            class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700"
          >
            Previous
          </button>
          <button
            v-if="rooms.links.next"
            @click="changePage(rooms.links.next)"
            class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Message when no rooms are available -->
      <div v-else>
        <p>No available rooms at the moment.</p>
      </div>
    </div>
  </template>

  <script setup>
  import { usePage } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';

  const { rooms } = usePage().props;

  // Function to change the page when clicking on pagination links
  const changePage = (url) => {
    Inertia.visit(url);
  };

  // Function to handle navigation to reservation page
  const goToReservation = (roomId) => {
    console.log('Navigating to reservation for room:', roomId);
    //Inertia.visit(`/client/reservations/rooms/${roomId}`);
    window.location.href = `/client/reservations/rooms/${roomId}`;
  };
  </script>

  <style scoped>
  /* Optional: Add custom styles for button */
  button {
    display: inline-block;
    text-align: center;
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
  }

  button:hover {
    background-color: #2563eb;
  }

  button:focus {
    outline: none;
  }
  </style>
