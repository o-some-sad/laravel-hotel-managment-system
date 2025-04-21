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
import { Bell } from 'lucide-vue-next';

defineProps({
  notifications: Array
});
</script>

<template>
  <Card>
    <CardHeader class="flex flex-row items-center justify-between">
      <div>
        <CardTitle>Notifications</CardTitle>
        <CardDescription>Stay updated with your bookings</CardDescription>
      </div>
      <Button variant="ghost" size="sm">Mark All Read</Button>
    </CardHeader>
    <CardContent>
      <div class="space-y-4">
        <div v-for="notification in notifications" :key="notification.id" class="flex items-start gap-4 rounded-lg border p-4">
          <div class="rounded-full bg-primary/10 p-2">
            <Bell class="h-4 w-4 text-primary" />
          </div>
          <div class="grid gap-1">
            <p class="text-sm font-medium">{{ notification.message }}</p>
            <p class="text-xs text-muted-foreground">{{ notification.time }}</p>
          </div>
        </div>
      </div>
    </CardContent>
    <CardFooter>
      <Button variant="outline" class="w-full">View All Notifications</Button>
    </CardFooter>
  </Card>
</template>