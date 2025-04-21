<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useTheme } from "@/composables/useTheme";
import { 
  Calendar, 
  CreditCard,
  Hotel, 
  User,
  MessageSquare,
  Clock
} from 'lucide-vue-next';

// Import our components
import UserDashboardHeader from '@/components/user/UserDashboardHeader.vue';
import UserDashboardSidebar from '@/components/user/UserDashboardSidebar.vue';
import UserStatsCards from '@/components/user/UserStatsCards.vue';
import UserBookings from '@/components/user/UserBookings.vue';
import UserNotifications from '@/components/user/UserNotifications.vue';

const { theme, toggleTheme } = useTheme();
const isMobileSidebarOpen = ref(false);
const activeTab = ref('dashboard');

// Mock data for the user dashboard
const stats = [
  { title: 'Active Bookings', value: '2', icon: Calendar },
  { title: 'Total Spent', value: '$1,250', icon: CreditCard },
  { title: 'Loyalty Points', value: '450', icon: Hotel },
  { title: 'Upcoming Stay', value: 'May 20', icon: Clock },
];

const bookings = [
  { id: 'B-1234', room: 'Deluxe Suite', checkIn: '2023-05-20', checkOut: '2023-05-25', status: 'Confirmed', price: '$750' },
  { id: 'B-1235', room: 'Executive Room', checkIn: '2023-06-15', checkOut: '2023-06-18', status: 'Pending', price: '$500' },
  { id: 'B-1236', room: 'Standard Room', checkIn: '2023-07-10', checkOut: '2023-07-12', status: 'Cancelled', price: '$300' },
];

const notifications = [
  { id: 1, message: 'Your booking #B-1234 has been confirmed', time: '2 hours ago' },
  { id: 2, message: 'Special offer: 20% off on your next booking', time: '1 day ago' },
  { id: 3, message: 'Your room upgrade request is being processed', time: '3 days ago' },
];

const toggleSidebar = () => {
  isMobileSidebarOpen.value = !isMobileSidebarOpen.value;
};

const closeMobileSidebar = () => {
  isMobileSidebarOpen.value = false;
};
</script>

<template>
  <Head title="User Dashboard" />

  <div class="min-h-screen flex flex-col bg-background">
    <!-- User Dashboard Header -->
    <UserDashboardHeader 
      :theme="theme" 
      :isMobileSidebarOpen="isMobileSidebarOpen" 
      :notifications="notifications"
      :auth="$page.props.auth"
      @toggle-theme="toggleTheme"
      @toggle-sidebar="toggleSidebar"
    />

    <div class="flex flex-1 overflow-hidden">
      <!-- Sidebar -->
      <UserDashboardSidebar 
        v-model:activeTab="activeTab"
        :isMobileSidebarOpen="isMobileSidebarOpen"
        @close-mobile-sidebar="closeMobileSidebar"
      />

      <!-- Main content -->
      <main class="flex-1 overflow-y-auto p-4 md:p-6">
        <div class="space-y-6">
          <div>
            <h1 class="text-2xl font-bold tracking-tight">My Dashboard</h1>
            <p class="text-muted-foreground">Welcome back, {{ $page.props.auth.user.name }}</p>
          </div>

          <!-- Stats Cards -->
          <UserStatsCards :stats="stats" />

          <!-- Main Content Grid -->
          <div class="grid gap-6 md:grid-cols-2">
            <!-- Bookings -->
            <div class="md:col-span-2">
              <UserBookings :bookings="bookings" />
            </div>

            <!-- Notifications -->
            <div class="md:col-span-2 lg:col-span-1">
              <UserNotifications :notifications="notifications" />
            </div>

            <!-- Quick Actions -->
            <div class="md:col-span-2 lg:col-span-1">
              <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                  <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                  <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center justify-center p-4 rounded-md bg-primary/10 hover:bg-primary/20 transition-colors">
                      <Calendar class="h-6 w-6 mb-2 text-primary" />
                      <span>New Booking</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-md bg-primary/10 hover:bg-primary/20 transition-colors">
                      <MessageSquare class="h-6 w-6 mb-2 text-primary" />
                      <span>Contact Support</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-md bg-primary/10 hover:bg-primary/20 transition-colors">
                      <User class="h-6 w-6 mb-2 text-primary" />
                      <span>Edit Profile</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-md bg-primary/10 hover:bg-primary/20 transition-colors">
                      <Hotel class="h-6 w-6 mb-2 text-primary" />
                      <span>View Rooms</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>