<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useTheme } from "@/composables/useTheme";
import { 
  Calendar, 
  Users, 
  Hotel, 
  CreditCard
} from 'lucide-vue-next';

// Import our new components
import DashboardHeader from '@/components/dashboard/DashboardHeader.vue';
import DashboardSidebar from '@/components/dashboard/DashboardSidebar.vue';
import StatsCards from '@/components/dashboard/StatsCards.vue';
import RecentBookings from '@/components/dashboard/RecentBookings.vue';
import ActivityFeed from '@/components/dashboard/ActivityFeed.vue';

const { theme, toggleTheme } = useTheme();
const isMobileSidebarOpen = ref(false);
const activeTab = ref('dashboard');

// Mock data for the dashboard
const stats = [
  { title: 'Total Bookings', value: '1,234', change: '+12%', icon: Calendar },
  { title: 'Revenue', value: '$45,678', change: '+8.2%', icon: CreditCard },
  { title: 'Active Users', value: '892', change: '+5.1%', icon: Users },
  { title: 'Room Occupancy', value: '78%', change: '+3.4%', icon: Hotel },
];

const recentBookings = [
  { id: 'B-1234', guest: 'John Smith', room: 'Deluxe Suite', checkIn: '2023-05-15', status: 'Confirmed' },
  { id: 'B-1235', guest: 'Sarah Johnson', room: 'Executive Room', checkIn: '2023-05-16', status: 'Pending' },
  { id: 'B-1236', guest: 'Michael Brown', room: 'Standard Room', checkIn: '2023-05-17', status: 'Confirmed' },
  { id: 'B-1237', guest: 'Emily Davis', room: 'Presidential Suite', checkIn: '2023-05-18', status: 'Cancelled' },
];

const notifications = [
  { id: 1, message: 'New booking request received', time: '5 minutes ago' },
  { id: 2, message: 'Staff meeting at 3:00 PM', time: '1 hour ago' },
  { id: 3, message: 'Maintenance scheduled for Room 302', time: '3 hours ago' },
];

const toggleSidebar = () => {
  isMobileSidebarOpen.value = !isMobileSidebarOpen.value;
};

const closeMobileSidebar = () => {
  isMobileSidebarOpen.value = false;
};
</script>

<template>
  <Head title="Dashboard" />

  <div class="min-h-screen flex flex-col bg-background">
    <!-- Dashboard Header -->
    <DashboardHeader 
      :theme="theme" 
      :isMobileSidebarOpen="isMobileSidebarOpen" 
      :notifications="notifications"
      :auth="$page.props.auth"
      @toggle-theme="toggleTheme"
      @toggle-sidebar="toggleSidebar"
    />

    <div class="flex flex-1 overflow-hidden">
      <!-- Sidebar -->
      <DashboardSidebar 
        v-model:activeTab="activeTab"
        :isMobileSidebarOpen="isMobileSidebarOpen"
        @close-mobile-sidebar="closeMobileSidebar"
      />

      <!-- Main content -->
      <main class="flex-1 overflow-y-auto p-4 md:p-6">
        <div class="space-y-6">
          <div>
            <h1 class="text-2xl font-bold tracking-tight">Dashboard</h1>
            <p class="text-muted-foreground">Welcome back to your hotel management dashboard.</p>
          </div>

          <!-- Stats cards -->
          <StatsCards :stats="stats" />

          <div class="grid gap-6 md:grid-cols-2">
            <!-- Recent bookings -->
            <RecentBookings :bookings="recentBookings" />

            <!-- Activity -->
            <ActivityFeed :notifications="notifications" />
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
