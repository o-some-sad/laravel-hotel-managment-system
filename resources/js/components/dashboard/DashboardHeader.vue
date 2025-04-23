<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
  DropdownMenuLabel,
  DropdownMenuGroup,
} from "@/components/ui/dropdown-menu";
import { 
  User, 
  Hotel, 
  Bell, 
  LogOut, 
  Moon, 
  Sun,
  Settings,
  UserCircle,
  CreditCard,
  HelpCircle,
  Mail,
  Shield
} from 'lucide-vue-next';
import { useTheme } from "@/composables/useTheme";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";

const props = defineProps({
  auth: Object
});

const { theme, toggleTheme } = useTheme();

const emit = defineEmits(['toggle-theme']);

// Get user initials for avatar fallback
const getUserInitials = (name) => {
  if (!name) return 'U';
  return name
    .split(' ')
    .map(part => part.charAt(0))
    .join('')
    .toUpperCase()
    .substring(0, 2);
};
</script>

<template>
  <header class="sticky top-0 z-40 border-b bg-background">
    <div class="flex h-16 items-center justify-between px-4 md:px-6">
      <!-- Logo Section -->
      <div class="flex items-center gap-2">
        <Hotel class="h-6 w-6 text-primary" />
        <Link href="/dashboard" class="font-semibold text-xl hidden md:block">Hotel Management</Link>
      </div>
      
      <!-- Right Section: Notifications and User Profile -->
      <div class="flex items-center gap-4">
        <!-- Theme Toggle -->
        <Button variant="ghost" size="icon" @click="$emit('toggle-theme')">
          <Sun v-if="theme === 'dark'" class="h-5 w-5" />
          <Moon v-else class="h-5 w-5" />
          <span class="sr-only">Toggle theme</span>
        </Button>
        
        <!-- User Profile Dropdown -->
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" class="relative h-8 rounded-full flex items-center gap-2 px-2">
              <Avatar class="h-8 w-8">
                <AvatarImage :src="props.auth?.user?.profile_photo_url" alt="Profile" />
                <AvatarFallback class="bg-primary/10 text-primary text-xs">
                  {{ getUserInitials(props.auth?.user?.name) }}
                </AvatarFallback>
              </Avatar>
              <span class="font-medium text-sm hidden md:block">
                {{ props.auth?.user?.name || 'User' }}
              </span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end" class="w-56">
            <div class="p-1">
              <DropdownMenuItem class="cursor-pointer text-destructive focus:text-destructive">
                <Link :href="route('logout')" method="post" as="button" class="flex w-full items-center">
                  <LogOut class="mr-2 h-4 w-4" />
                  <span>Log out</span>
                </Link>
              </DropdownMenuItem>
            </div>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </div>
  </header>
</template>