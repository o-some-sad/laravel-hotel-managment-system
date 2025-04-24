<script setup>
import { Button } from "@/components/ui/button";
import { Link } from '@inertiajs/vue3';
import {
  Bed,
  ArrowUpNarrowWide,
  Home,
  Menu,
  X,
  Users
} from 'lucide-vue-next';

const props = defineProps({
  isMobileMenuOpen: Boolean
});

const emit = defineEmits(['toggle-mobile-menu']);

const navigation = [
  {
    title: 'Dashboard',
    icon: Home,
    route: route('dashboard'),
    active: (route) => route === 'dashboard'
  },
  {
    title: 'Rooms',
    icon: Bed,
    route: route('rooms.index'),
    active: (route) => route.includes('rooms')
  },
  {
    title: 'Manager Receptionists', 
    icon: Users,
    route: route('manager.receptionists.index'),
    active: (route) => route.includes('manager.receptionists')
  },
  {
    title: 'Floors',
    icon: ArrowUpNarrowWide,
    route: route('floor.index'),
    active: (route) => route.includes('floor')
  },
  {
    title: '(Admin) Manage Managers',
    icon: Users,
    route: route('managers.index'),
    active: (route) => route.includes('managers'),
    requiresAdmin: true
  },
  // {
  //   title: '(Admin) Manage Receptionists',
  //   icon: Users,
  //   route: route('dashboard.receptionists.index'),
  //   active: (route) => route.includes('dashboard.receptionists'),
  //   requiresAdmin: true
  // },
];

const currentRoute = route().current();
</script>

<template>
  <!-- Mobile Menu Toggle Button (visible on mobile only) -->
  <Button 
    variant="ghost" 
    size="icon" 
    class="fixed top-4 right-4 z-50 md:hidden" 
    @click="$emit('toggle-mobile-menu')"
  >
    <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
    <X v-else class="h-6 w-6" />
  </Button>

  <!-- Desktop Sidebar -->
  <aside class="hidden md:block w-64 border-r bg-card h-[calc(100vh-64px)]">
    <div class="flex flex-col gap-1 p-4 h-full overflow-y-auto">
      <nav class="space-y-1">
        <Link 
          v-for="item in navigation" 
          :key="item.title" 
          :href="item.route" 
          :class="[
            'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors',
            item.active(currentRoute) 
              ? 'bg-primary text-primary-foreground' 
              : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'
          ]"
        >
          <component :is="item.icon" class="h-4 w-4" />
          {{ item.title }}
        </Link>
      </nav>
    </div>
  </aside>

  <!-- Mobile Sidebar (overlay) -->
  <div 
    v-if="isMobileMenuOpen" 
    class="fixed inset-0 z-40 bg-background/80 backdrop-blur-sm md:hidden"
    @click="$emit('toggle-mobile-menu')"
  >
    <div 
      class="fixed inset-y-0 left-0 w-64 bg-card border-r h-full"
      @click.stop
    >
      <div class="p-4 h-full overflow-y-auto">
        <div class="flex items-center gap-2 mb-6 mt-2">
          <Link href="/dashboard" class="font-semibold text-xl">Hotel Management</Link>
        </div>
        <nav class="space-y-1">
          <Link 
            v-for="item in navigation" 
            :key="item.title" 
            :href="item.route" 
            :class="[
              'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors',
              item.active(currentRoute) 
                ? 'bg-primary text-primary-foreground' 
                : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'
            ]"
            @click="$emit('toggle-mobile-menu')"
          >
            <component :is="item.icon" class="h-4 w-4" />
            {{ item.title }}
          </Link>
        </nav>
      </div>
    </div>
  </div>
</template>