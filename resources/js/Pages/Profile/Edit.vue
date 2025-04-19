<script setup>
import { Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
</script>

<template>
  <Head title="Profile" />

  <DashboardLayout title="Profile">
    <Tabs default-value="personal-info" class="w-full">
      <TabsList class="grid w-full grid-cols-3">
        <TabsTrigger value="personal-info">Personal Info</TabsTrigger>
        <TabsTrigger value="password">Password</TabsTrigger>
        <TabsTrigger value="account">Account</TabsTrigger>
      </TabsList>
      
      <TabsContent value="personal-info" class="mt-6">
        <UpdateProfileInformationForm
          :must-verify-email="mustVerifyEmail"
          :status="status"
        />
      </TabsContent>
      
      <TabsContent value="password" class="mt-6">
        <UpdatePasswordForm />
      </TabsContent>
      
      <TabsContent value="account" class="mt-6">
        <DeleteUserForm />
      </TabsContent>
    </Tabs>
  </DashboardLayout>
</template>
