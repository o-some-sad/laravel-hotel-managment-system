<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { useToast } from "vue-toastification";

const props = defineProps({
  receptionist: Object,
});

const toast = useToast();

const form = useForm({
  name: props.receptionist.name,
  email: props.receptionist.email,
  password: '',
  password_confirmation: '',
  national_id: props.receptionist.national_id || '',
  avatar_image: null,
  _method: 'PUT',
});

const isSubmitting = ref(false);
const previewImage = ref(null);

onMounted(() => {
  if (props.receptionist.avatar_image) {
    previewImage.value = props.receptionist.avatar_image;
  }
});

const handleImageUpload = (e) => {
  const file = e.target.files[0];
  form.avatar_image = file;
  
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const submit = () => {
  isSubmitting.value = true;
  form.post(route('dashboard.receptionists.update', props.receptionist.id), {
    onSuccess: () => {
      toast.success('Receptionist updated successfully');
      isSubmitting.value = false;
    },
    onError: () => {
      toast.error('Failed to update receptionist');
      isSubmitting.value = false;
    },
  });
};
</script>

<template>
  <Head title="Edit Receptionist" />

  <DashboardLayout>
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Edit Receptionist</h1>
        <p class="text-muted-foreground">Update receptionist information</p>
      </div>

      <Card class="max-w-2xl mx-auto">
        <CardHeader>
          <CardTitle>Receptionist Information</CardTitle>
          <CardDescription>
            Update the details for {{ receptionist.name }}
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">
            <div class="space-y-2">
              <Label for="name">Name</Label>
              <Input 
                id="name" 
                v-model="form.name" 
                type="text" 
                :class="{ 'border-red-500': form.errors.name }" 
                required 
              />
              <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
            </div>

            <div class="space-y-2">
              <Label for="email">Email</Label>
              <Input 
                id="email" 
                v-model="form.email" 
                type="email" 
                :class="{ 'border-red-500': form.errors.email }" 
                required 
              />
              <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
            </div>

            <div class="space-y-2">
              <Label for="national_id">National ID</Label>
              <Input 
                id="national_id" 
                v-model="form.national_id" 
                type="text" 
                :class="{ 'border-red-500': form.errors.national_id }" 
                required 
              />
              <p v-if="form.errors.national_id" class="text-sm text-red-500">{{ form.errors.national_id }}</p>
            </div>

            <div class="space-y-2">
              <Label for="password">Password (min 6 characters, leave blank to keep current)</Label>
              <Input 
                id="password" 
                v-model="form.password" 
                type="password" 
                :class="{ 'border-red-500': form.errors.password }" 
              />
              <p v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</p>
            </div>

            <div class="space-y-2">
              <Label for="password_confirmation">Confirm Password</Label>
              <Input 
                id="password_confirmation" 
                v-model="form.password_confirmation" 
                type="password" 
              />
            </div>

            <div class="space-y-2">
              <Label for="avatar_image">Profile Picture (jpg/jpeg only)</Label>
              <Input 
                id="avatar_image" 
                type="file" 
                accept=".jpg,.jpeg" 
                @change="handleImageUpload" 
                :class="{ 'border-red-500': form.errors.avatar_image }" 
              />
              <p v-if="form.errors.avatar_image" class="text-sm text-red-500">{{ form.errors.avatar_image }}</p>
              
              <div v-if="previewImage" class="mt-2">
                <p class="text-sm mb-1">Current Profile Picture:</p>
                <img :src="previewImage" alt="Avatar Preview" class="w-24 h-24 object-cover rounded-full border" />
              </div>
            </div>

            <div class="flex justify-end pt-4">
              <Button 
                type="submit" 
                :disabled="isSubmitting || form.processing"
                class="w-full md:w-auto"
              >
                {{ isSubmitting ? 'Updating...' : 'Update Receptionist' }}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </DashboardLayout>
</template>