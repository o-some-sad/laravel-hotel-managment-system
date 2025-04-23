<template>
    <div class="space-y-6 max-w-2xl mx-auto">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold tracking-tight">Edit Receptionist</h2>
        <Button as="a" href="/manager/receptionists" variant="outline">
          Back to List
        </Button>
      </div>
  
      <!-- Form Card -->
      <Card>
        <CardHeader>
          <CardTitle>Receptionist Details</CardTitle>
          <CardDescription>Update the details of the receptionist.</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Name Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Name</label>
              <Input 
                v-model="form.name" 
                type="text" 
                placeholder="Enter name"
                :error="form.errors.name"
              />
            </div>
  
            <!-- Email Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <Input 
                v-model="form.email" 
                type="email" 
                placeholder="Enter email"
                :error="form.errors.email"
              />
            </div>
  
            <!-- Password Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Password (Leave blank to keep current)</label>
              <Input 
                v-model="form.password" 
                type="password" 
                placeholder="Enter new password"
                :error="form.errors.password"
              />
            </div>
  
            <!-- National ID Input -->
            <div>
              <label class="block text-sm font-medium mb-1">National ID</label>
              <Input 
                v-model="form.national_id" 
                type="text" 
                placeholder="Enter national ID"
                :error="form.errors.national_id"
              />
            </div>
          </form>
        </CardContent>
        <CardFooter class="flex justify-end gap-4">
          <Button @click="submitForm" :disabled="form.processing">
            {{ form.processing ? 'Updating...' : 'Update' }}
          </Button>
          <Button as="a" href="/manager/receptionists" variant="outline">
            Cancel
          </Button>
        </CardFooter>
      </Card>
  
      <!-- Success Message -->
      <Card v-if="showSuccess" class="bg-green-100 text-green-700">
        <CardContent>
          <p>✅ Receptionist updated successfully!</p>
          <Button as="a" href="/manager/receptionists" variant="link">
            Back to List
          </Button>
        </CardContent>
      </Card>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import { ref } from 'vue';
  import { Input } from '@/components/ui/input';
  import { Button } from '@/components/ui/button';
  import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
  
  const props = defineProps({
    receptionist: Object,
  });
  
  const showSuccess = ref(false);
  
  const form = useForm({
    name: props.receptionist.name,
    email: props.receptionist.email,
    password: '',
    national_id: props.receptionist.national_id,
  });
  
  const submitForm = () => {
    form.put(`/manager/receptionists/${props.receptionist.id}`, {
      onSuccess: () => {
        if (Object.keys(form.errors).length === 0) {
          showSuccess.value = true;
        }
      },
    });
  };
  </script>