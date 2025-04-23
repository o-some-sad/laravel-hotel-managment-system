<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { 
  Card, 
  CardContent, 
  CardDescription, 
  CardFooter, 
  CardHeader, 
  CardTitle 
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
  room: Object,
  floors: Array
});

const form = useForm({
  number: props.room.number,
  capacity: props.room.capacity,
  price: (props.room.price / 100).toFixed(2), // Convert cents to dollars for display
  floor_id: props.room.floor_id
});

const submit = () => {
  // Convert price from dollars to cents
  const priceInCents = Math.round(parseFloat(form.price) * 100);
  
  form.put(route('rooms.update', props.room.id), {
    data: {
      ...form.data(),
      price: priceInCents
    }
  });
};
</script>

<template>
  <Head title="Edit Room" />
  
  <DashboardLayout>
    <Card>
      <CardHeader>
        <CardTitle>Edit Room</CardTitle>
        <CardDescription>Update room information</CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="submit" class="space-y-6">
          <div class="grid gap-4">
            <div class="space-y-2">
              <Label for="number">Room Number (min 4 digits)</Label>
              <Input 
                id="number" 
                v-model="form.number" 
                placeholder="e.g. 1001" 
                :error="form.errors.number"
                minlength="4"
                required
              />
              <p v-if="form.errors.number" class="text-sm text-destructive">{{ form.errors.number }}</p>
            </div>
            
            <div class="space-y-2">
              <Label for="capacity">Capacity</Label>
              <Input 
                id="capacity" 
                v-model="form.capacity" 
                type="number" 
                min="1" 
                placeholder="e.g. 2" 
                :error="form.errors.capacity"
                required
              />
              <p v-if="form.errors.capacity" class="text-sm text-destructive">{{ form.errors.capacity }}</p>
            </div>
            
            <div class="space-y-2">
              <Label for="price">Price (in dollars)</Label>
              <Input 
                id="price" 
                v-model="form.price" 
                type="number" 
                min="0.01" 
                step="0.01" 
                placeholder="e.g. 99.99" 
                :error="form.errors.price"
                required
              />
              <p v-if="form.errors.price" class="text-sm text-destructive">{{ form.errors.price }}</p>
            </div>
            
            <div class="space-y-2">
              <Label for="floor">Floor</Label>
              <Select v-model="form.floor_id" required>
                <SelectTrigger :error="form.errors.floor_id">
                  <SelectValue placeholder="Select a floor" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem 
                    v-for="floor in floors" 
                    :key="floor.id" 
                    :value="floor.id"
                  >
                    {{ floor.name }}
                  </SelectItem>
                </SelectContent>
              </Select>
              <p v-if="form.errors.floor_id" class="text-sm text-destructive">{{ form.errors.floor_id }}</p>
            </div>
          </div>
          
          <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing">Update Room</Button>
          </div>
        </form>
      </CardContent>
    </Card>
  </DashboardLayout>
</template>