<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { 
  User, 
  Hotel, 
  Bell, 
  LogOut, 
  Menu as MenuIcon, 
  X, 
  Moon, 
  Sun,
  Search,
  Settings
} from 'lucide-vue-next';

const props = defineProps({
  theme: String,
  isMobileSidebarOpen: Boolean,
  notifications: Array,
  auth: Object
});

const emit = defineEmits(['toggle-theme', 'toggle-sidebar']);

const toggleSidebar = () => {
  emit('toggle-sidebar');
};

const toggleTheme = () => {
  emit('toggle-theme');
};
</script>

<template>
  <header class="border-b bg-card shadow-sm">
    <div class="flex h-16 items-center px-4 md:px-6">
      <!-- Mobile menu button -->
      <Button variant="ghost" size="icon" class="md:hidden mr-2" @click="toggleSidebar">
        <MenuIcon v-if="!isMobileSidebarOpen" class="h-5 w-5" />
        <X v-else class="h-5 w-5" />
      </Button>
      
      <!-- Logo -->
      <div class="flex items-center gap-2 font-semibold text-lg">
        <Hotel class="h-5 w-5 text-primary" />
        <span>Hotel Guest Portal</span>
      </div>
      
      <!-- Search -->
      <div class="flex-1 flex justify-center px-6 hidden md:flex">
        <div class="relative w-full max-w-md">
          <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <input 
            type="search" 
            placeholder="Search bookings, rooms..." 
            class="w-full bg-background rounded-md border border-input pl-8 pr-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
          />
        </div>
      </div>
      
      <!-- Right side actions -->
      <div class="flex items-center gap-4 ml-auto">
        <!-- Theme toggle -->
        <Button variant="ghost" size="icon" @click="toggleTheme" class="rounded-full">
          <Sun v-if="theme === 'dark'" class="h-5 w-5" />
          <Moon v-else class="h-5 w-5" />
        </Button>
        
        <!-- Notifications -->
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" size="icon" class="rounded-full relative">
              <Bell class="h-5 w-5" />
              <span v-if="notifications.length > 0" class="absolute top-0 right-0 h-2 w-2 rounded-full bg-destructive"></span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end" class="w-80">
            <div class="flex items-center justify-between p-4">
              <span class="font-medium">Notifications</span>
              <Button variant="ghost" size="sm">Mark all as read</Button>
            </div>
            <Separator class="my-1" />
            <div class="max-h-80 overflow-y-auto">
              <div v-for="notification in notifications" :key="notification.id" class="p-3 hover:bg-muted rounded-md">
                <div class="text-sm">{{ notification.message }}</div>
                <div class="text-xs text-muted-foreground mt-1">{{ notification.time }}</div>
              </div>
            </div>
            <Separator class="my-1" />
            <div class="p-2">
              <Button variant="outline" size="sm" class="w-full">View all notifications</Button>
            </div>
          </DropdownMenuContent>
        </DropdownMenu>
        
        <!-- User menu -->
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" size="icon" class="rounded-full">
              <User class="h-5 w-5" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <div class="flex items-center justify-start gap-2 p-2">
              <div class="rounded-full bg-primary/10 p-1">
                <User class="h-8 w-8 text-primary" />
              </div>
              <div>
                <p class="text-sm font-medium">{{ auth.user.name }}</p>
                <p class="text-xs text-muted-foreground">{{ auth.user.email }}</p>
              </div>
            </div>
            <Separator />
            <DropdownMenuItem>
              <Link :href="route('profile.edit')" class="w-full flex items-center">
                <User class="mr-2 h-4 w-4" />
                <span>My Profile</span>
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem>
              <Link href="#" class="w-full flex items-center">
                <Settings class="mr-2 h-4 w-4" />
                <span>Account Settings</span>
              </Link>
            </DropdownMenuItem>
            <Separator />
            <DropdownMenuItem>
              <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center text-destructive">
                <LogOut class="mr-2 h-4 w-4" />
                <span>Log Out</span>
              </Link>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </div>
  </header>
</template>