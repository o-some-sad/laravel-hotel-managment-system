<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { 
  Card, 
  CardContent, 
  CardDescription, 
  CardFooter, 
  CardHeader, 
  CardTitle 
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { 
  Users, 
  Calendar, 
  CreditCard, 
  Hotel,
  Bed,
  ArrowUpRight
} from 'lucide-vue-next';

// Sample stats data
const stats = [
  { title: 'Total Rooms', value: '120', icon: Bed, change: '+5%' },
  { title: 'Occupancy Rate', value: '78%', icon: Hotel, change: '+2.5%' },
  { title: 'Reservations', value: '450', icon: Calendar, change: '+12%' },
  { title: 'Revenue', value: '$45,231', icon: CreditCard, change: '+8.2%' },
];

// Sample recent bookings
const recentBookings = [
  { id: 'B-1234', guest: 'John Smith', room: 'Deluxe Suite', checkIn: '2023-05-20', checkOut: '2023-05-25', status: 'Confirmed' },
  { id: 'B-1235', guest: 'Sarah Johnson', room: 'Executive Room', checkIn: '2023-06-15', checkOut: '2023-06-18', status: 'Pending' },
  { id: 'B-1236', guest: 'Michael Brown', room: 'Standard Room', checkIn: '2023-07-10', checkOut: '2023-07-12', status: 'Cancelled' },
  { id: 'B-1237', guest: 'Emily Davis', room: 'Family Suite', checkIn: '2023-07-15', checkOut: '2023-07-20', status: 'Confirmed' },
];

const getStatusColor = (status) => {
  switch (status) {
    case 'Confirmed':
      return 'text-green-600 bg-green-100';
    case 'Pending':
      return 'text-yellow-600 bg-yellow-100';
    case 'Cancelled':
      return 'text-red-600 bg-red-100';
    default:
      return 'text-gray-600 bg-gray-100';
  }
};
</script>

<template>
  <DashboardLayout title="Dashboard">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
        <Button>
          <Calendar class="mr-2 h-4 w-4" />
          View Calendar
        </Button>
      </div>
      
      <!-- Stats Cards -->
      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card v-for="stat in stats" :key="stat.title">
          <CardContent class="p-6">
            <div class="flex items-center justify-between space-x-4">
              <div>
                <p class="text-sm font-medium text-muted-foreground">{{ stat.title }}</p>
                <div class="flex items-center gap-2">
                  <p class="text-2xl font-bold">{{ stat.value }}</p>
                  <span class="text-xs font-medium text-green-600">{{ stat.change }}</span>
                </div>
              </div>
              <div class="rounded-full bg-primary/10 p-2">
                <component :is="stat.icon" class="h-5 w-5 text-primary" />
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
      
      <!-- Recent Bookings -->
      <Card>
        <CardHeader class="flex flex-row items-center justify-between">
          <div>
            <CardTitle>Recent Bookings</CardTitle>
            <CardDescription>Overview of the latest reservations</CardDescription>
          </div>
          <Button variant="outline" size="sm">
            View All
            <ArrowUpRight class="ml-2 h-4 w-4" />
          </Button>
        </CardHeader>
        <CardContent>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b text-sm">
                  <th class="pb-2 text-left font-medium">Booking ID</th>
                  <th class="pb-2 text-left font-medium">Guest</th>
                  <th class="pb-2 text-left font-medium">Room</th>
                  <th class="pb-2 text-left font-medium">Check In</th>
                  <th class="pb-2 text-left font-medium">Check Out</th>
                  <th class="pb-2 text-left font-medium">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="booking in recentBookings" :key="booking.id" class="border-b">
                  <td class="py-3 text-sm">{{ booking.id }}</td>
                  <td class="py-3 text-sm">{{ booking.guest }}</td>
                  <td class="py-3 text-sm">{{ booking.room }}</td>
                  <td class="py-3 text-sm">{{ booking.checkIn }}</td>
                  <td class="py-3 text-sm">{{ booking.checkOut }}</td>
                  <td class="py-3 text-sm">
                    <span :class="[
                      'inline-block rounded-full px-2 py-1 text-xs font-medium',
                      getStatusColor(booking.status)
                    ]">
                      {{ booking.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>
    </div>
  </DashboardLayout>
</template>

