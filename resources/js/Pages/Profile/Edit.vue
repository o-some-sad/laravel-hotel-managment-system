<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

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

  <div class="min-h-screen flex flex-col bg-background">
    <Navbar :auth="$page.props.auth" />
    
    <main class="flex-1 container mx-auto px-4 py-8">
      <Card>
        <CardHeader>
          <CardTitle>Profile</CardTitle>
        </CardHeader>
        <CardContent>
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
        </CardContent>
      </Card>
    </main>
    
    <Footer />
  </div>
</template>
