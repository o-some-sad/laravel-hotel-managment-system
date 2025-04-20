<script setup>
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

const props = defineProps({
  stats: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
    <Card v-for="(stat, index) in stats" :key="index">
      <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
        <CardTitle class="text-sm font-medium">{{ stat.title }}</CardTitle>
        <component :is="stat.icon" class="h-4 w-4 text-muted-foreground" />
      </CardHeader>
      <CardContent>
        <div class="text-2xl font-bold">{{ stat.value }}</div>
        <p class="text-xs text-muted-foreground flex items-center">
          <span :class="stat.change.startsWith('+') ? 'text-green-500' : 'text-red-500'">{{ stat.change }}</span>
          <span class="ml-1">from last month</span>
        </p>
      </CardContent>
    </Card>
  </div>
</template>