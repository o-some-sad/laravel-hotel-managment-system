<script setup>
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Bell } from 'lucide-vue-next';

const props = defineProps({
  notifications: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Recent Activity</CardTitle>
      <CardDescription>Your recent actions and notifications</CardDescription>
    </CardHeader>
    <CardContent>
      <div class="space-y-4">
        <div v-for="(notification, index) in notifications" :key="notification.id" 
             class="flex items-start gap-4 rounded-md p-3" 
             :class="{'border-b pb-4': index < notifications.length - 1}">
          <div class="rounded-full bg-primary/10 p-2">
            <Bell class="h-4 w-4 text-primary" />
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium">{{ notification.message }}</p>
            <p class="text-xs text-muted-foreground">{{ notification.time }}</p>
          </div>
        </div>
        <div class="flex justify-end">
          <Button variant="outline" size="sm">View all activity</Button>
        </div>
      </div>
    </CardContent>
  </Card>
</template>