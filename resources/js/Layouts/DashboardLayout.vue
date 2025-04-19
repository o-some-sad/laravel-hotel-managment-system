<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { useTheme } from "@/composables/useTheme";
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import { Home, User, Settings, LogOut, Menu, X } from 'lucide-vue-next';

const { theme, toggleTheme } = useTheme();
const isSidebarOpen = ref(false);

defineProps({
  title: String,
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-background">
    <Navbar :auth="$page.props.auth" />
    
    <div class="flex-1 container mx-auto px-4 py-8 grid md:grid-cols-[240px_1fr] gap-8">
      <!-- Sidebar for larger screens -->
      <div class="hidden md:block">
        <Card>
          <CardHeader>
            <CardTitle>Dashboard</CardTitle>
            <CardDescription>Manage your hotel account</CardDescription>
          </CardHeader>
          <CardContent>
            <nav class="space-y-2">
              <Link :href="route('dashboard')" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent" :class="{ 'bg-accent': route().current('dashboard') }">
                <Home class="h-4 w-4" />
                <span>Dashboard</span>
              </Link>
              <Link :href="route('profile.edit')" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent" :class="{ 'bg-accent': route().current('profile.edit') }">
                <User class="h-4 w-4" />
                <span>Profile</span>
              </Link>
              <Link :href="route('logout')" method="post" as="button" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent w-full text-left text-destructive">
                <LogOut class="h-4 w-4" />
                <span>Logout</span>
              </Link>
            </nav>
          </CardContent>
        </Card>
      </div>
      
      <!-- Mobile sidebar toggle -->
      <div class="md:hidden mb-4">
        <Button variant="outline" @click="isSidebarOpen = !isSidebarOpen" class="w-full flex items-center justify-between">
          <span>Menu</span>
          <Menu v-if="!isSidebarOpen" class="h-4 w-4" />
          <X v-else class="h-4 w-4" />
        </Button>
        
        <!-- Mobile sidebar -->
        <Card v-if="isSidebarOpen" class="mt-2">
          <CardContent class="p-4">
            <nav class="space-y-2">
              <Link :href="route('dashboard')" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent" :class="{ 'bg-accent': route().current('dashboard') }">
                <Home class="h-4 w-4" />
                <span>Dashboard</span>
              </Link>
              <Link :href="route('profile.edit')" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent" :class="{ 'bg-accent': route().current('profile.edit') }">
                <User class="h-4 w-4" />
                <span>Profile</span>
              </Link>
              <Link :href="route('logout')" method="post" as="button" class="flex items-center gap-2 p-2 rounded-md hover:bg-accent w-full text-left text-destructive">
                <LogOut class="h-4 w-4" />
                <span>Logout</span>
              </Link>
            </nav>
          </CardContent>
        </Card>
      </div>
      
      <!-- Main content -->
      <main>
        <Card>
          <CardHeader>
            <CardTitle>{{ title }}</CardTitle>
          </CardHeader>
          <CardContent>
            <slot />
          </CardContent>
        </Card>
      </main>
    </div>
    
    <Footer />
  </div>
</template>