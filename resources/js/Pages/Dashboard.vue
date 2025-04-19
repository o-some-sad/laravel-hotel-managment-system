<script setup>
import { Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
</script>

<template>
  <Head title="Dashboard" />

  <DashboardLayout title="Dashboard">
    <div class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <Card>
          <CardHeader class="pb-2">
            <CardTitle class="text-sm font-medium">Total Bookings</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-2xl font-bold">12</div>
            <p class="text-xs text-muted-foreground">+2.5% from last month</p>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader class="pb-2">
            <CardTitle class="text-sm font-medium">Upcoming Stays</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-2xl font-bold">3</div>
            <p class="text-xs text-muted-foreground">Next stay in 5 days</p>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader class="pb-2">
            <CardTitle class="text-sm font-medium">Loyalty Points</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-2xl font-bold">1,250</div>
            <p class="text-xs text-muted-foreground">250 points until next reward</p>
          </CardContent>
        </Card>
      </div>
      
      <Card>
        <CardHeader>
          <CardTitle>Recent Activity</CardTitle>
          <CardDescription>Your recent bookings and account activity</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div class="flex items-center justify-between border-b pb-4">
              <div>
                <p class="font-medium">Booking Confirmed</p>
                <p class="text-sm text-muted-foreground">Deluxe Room - May 15-18, 2024</p>
              </div>
              <span class="text-sm text-muted-foreground">2 days ago</span>
            </div>
            <div class="flex items-center justify-between border-b pb-4">
              <div>
                <p class="font-medium">Profile Updated</p>
                <p class="text-sm text-muted-foreground">You updated your contact information</p>
              </div>
              <span class="text-sm text-muted-foreground">1 week ago</span>
            </div>
            <div class="flex items-center justify-between">
              <div>
                <p class="font-medium">Points Earned</p>
                <p class="text-sm text-muted-foreground">+250 points from your last stay</p>
              </div>
              <span class="text-sm text-muted-foreground">2 weeks ago</span>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </DashboardLayout>
</template>
