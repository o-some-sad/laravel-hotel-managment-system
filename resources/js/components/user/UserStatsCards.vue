<script setup>
import { Card, CardContent } from "@/components/ui/card";

defineProps({
  stats: Array
});
</script>

<template>
  <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
    <Card v-for="stat in stats" :key="stat.title">
      <CardContent class="p-6">
        <div class="flex items-center justify-between space-x-4">
          <div>
            <p class="text-sm font-medium text-muted-foreground">{{ stat.title }}</p>
            <p class="text-2xl font-bold">{{ stat.value }}</p>
          </div>
          <div class="rounded-full bg-primary/10 p-2">
            <component :is="stat.icon" class="h-5 w-5 text-primary" />
          </div>
        </div>
      </CardContent>
    </Card>
  </div>
</template>