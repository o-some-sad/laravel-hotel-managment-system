<template>
    <div class="space-y-6 max-w-3xl mx-auto">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold tracking-tight">Create New Receptionist</h2>
        <Button as="a" href="/manager/receptionists" variant="outline">
          Back to List
        </Button>
      </div>
  
      <!-- Form Card -->
      <Card>
        <CardHeader>
          <CardTitle>Receptionist Details</CardTitle>
          <CardDescription>Fill in the details to create a new receptionist.</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submitForm" class="space-y-6">
            <!-- Name Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Name</label>
              <Input 
                v-model="form.name" 
                type="text" 
                placeholder="Enter name"
                :class="{ 'border-red-500': form.errors.name }"
              />
              <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
            </div>
  
            <!-- Email Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <Input 
                v-model="form.email" 
                type="email" 
                placeholder="Enter email"
                :class="{ 'border-red-500': form.errors.email }"
              />
              <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
            </div>
  
            <!-- Password Input -->
            <div>
              <label class="block text-sm font-medium mb-1">Password</label>
              <Input 
                v-model="form.password" 
                type="password" 
                placeholder="Enter password"
                :class="{ 'border-red-500': form.errors.password }"
              />
              <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
            </div>
  
            <!-- National ID Input -->
            <div>
              <label class="block text-sm font-medium mb-1">National ID</label>
              <Input 
                v-model="form.national_id" 
                type="text" 
                placeholder="Enter national ID"
                :class="{ 'border-red-500': form.errors.national_id }"
              />
              <p v-if="form.errors.national_id" class="text-red-500 text-sm mt-1">{{ form.errors.national_id }}</p>
            </div>
          </form>
        </CardContent>
        <CardFooter class="flex justify-end gap-4">
          <Button @click="submitForm" :disabled="form.processing">
            {{ form.processing ? 'Creating...' : 'Create' }}
          </Button>
          <Button as="a" href="/manager/receptionists" variant="outline">
            Cancel
          </Button>
        </CardFooter>
      </Card>
  
      <!-- Success Message -->
      <Card v-if="showSuccess" class="bg-green-100 text-green-700">
        <CardContent>
          <p>✅ Receptionist created successfully!</p>
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
  
  const showSuccess = ref(false);
  
  const form = useForm({
    name: '',
    email: '',
    password: '',
    national_id: '',
  });
  
  const submitForm = () => {
    form.post('/manager/receptionists', {
      onFinish: () => {
        if (Object.keys(form.errors).length === 0) {
          form.reset();
          showSuccess.value = true;
        }
      },
    });
  };
  </script>