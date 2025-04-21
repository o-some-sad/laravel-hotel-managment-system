<script setup>
import { 
  Card, 
  CardContent, 
  CardDescription, 
  CardFooter, 
  CardHeader, 
  CardTitle 
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Calendar, Hotel, ArrowRight, Edit, XCircle } from 'lucide-vue-next';

defineProps({
  bookings: Array
});

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
</script>

<template>
  <Card>
    <CardHeader class="flex flex-row items-center justify-between">
      <div>
        <CardTitle>My Bookings</CardTitle>
        <CardDescription>Manage your hotel reservations</CardDescription>
      </div>
      <Button size="sm">View All</Button>
    </CardHeader>
    <CardContent>
      <div class="space-y-4">
        <div v-for="booking in bookings" :key="booking.id" class="rounded-lg border p-4">
          <div class="grid gap-4 md:grid-cols-[1fr_auto]">
            <div class="grid gap-1">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <Hotel class="h-4 w-4 text-primary" />
                  <span class="font-semibold">{{ booking.room }}</span>
                </div>
                <Badge :class="getStatusColor(booking.status)">{{ booking.status }}</Badge>
              </div>
              <div class="text-sm text-muted-foreground">Booking ID: {{ booking.id }}</div>
              <div class="flex items-center gap-2 mt-2">
                <Calendar class="h-4 w-4 text-muted-foreground" />
                <span class="text-sm">{{ booking.checkIn }}</span>
                <ArrowRight class="h-3 w-3 text-muted-foreground" />
                <span class="text-sm">{{ booking.checkOut }}</span>
              </div>
              <div class="font-medium mt-2">{{ booking.price }}</div>
            </div>
            <div class="flex items-center gap-2 self-end">
              <Button v-if="booking.status !== 'Cancelled'" variant="outline" size="sm">
                <Edit class="h-4 w-4 mr-1" />
                Modify
              </Button>
              <Button v-if="booking.status !== 'Cancelled'" variant="destructive" size="sm">
                <XCircle class="h-4 w-4 mr-1" />
                Cancel
              </Button>
              <Button v-if="booking.status === 'Cancelled'" variant="outline" size="sm">
                Book Again
              </Button>
            </div>
          </div>
        </div>
      </div>
    </CardContent>
    <CardFooter>
      <Button variant="outline" class="w-full">Make a New Booking</Button>
    </CardFooter>
  </Card>
</template>