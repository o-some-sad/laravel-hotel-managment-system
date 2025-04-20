<script setup>
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

const props = defineProps({
  bookings: {
    type: Array,
    required: true
  }
});

const getStatusClass = (status) => {
  switch(status) {
    case 'Confirmed': return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
    case 'Pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
    case 'Cancelled': return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
    default: return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400';
  }
};
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Recent Bookings</CardTitle>
      <CardDescription>Latest hotel reservations</CardDescription>
    </CardHeader>
    <CardContent>
      <div class="space-y-4">
        <div class="rounded-md border">
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b bg-muted/50">
                  <th class="px-4 py-2 text-left font-medium">ID</th>
                  <th class="px-4 py-2 text-left font-medium">Guest</th>
                  <th class="px-4 py-2 text-left font-medium">Room</th>
                  <th class="px-4 py-2 text-left font-medium">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="booking in bookings" :key="booking.id" class="border-b">
                  <td class="px-4 py-2">{{ booking.id }}</td>
                  <td class="px-4 py-2">{{ booking.guest }}</td>
                  <td class="px-4 py-2">{{ booking.room }}</td>
                  <td class="px-4 py-2">
                    <span :class="`px-2 py-1 rounded-full text-xs font-medium ${getStatusClass(booking.status)}`">
                      {{ booking.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="flex justify-end">
          <Button variant="outline" size="sm">View all bookings</Button>
        </div>
      </div>
    </CardContent>
  </Card>
</template>