<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useTheme } from "@/composables/useTheme";
import AsideMenu from '@/components/dashboard/AsideMenu.vue';
import DashboardHeader from '@/components/dashboard/DashboardHeader.vue';

const { theme, toggleTheme } = useTheme();
const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

defineProps({
  title: String,
  auth: Object
});
</script>

<template>
  <Head :title="title" />
  
  <div class="flex min-h-screen flex-col bg-background">
    <!-- Dashboard Header -->
    <DashboardHeader :auth="auth" @toggle-theme="toggleTheme" />
    
    <div class="flex flex-1">
      <!-- Sidebar -->
      <AsideMenu :is-mobile-menu-open="isMobileMenuOpen" @toggle-mobile-menu="toggleMobileMenu" />
      
      <!-- Main Content -->
      <main class="flex-1 p-4 md:p-6 overflow-y-auto">
        <slot></slot>
      </main>
    </div>
  </div>
</template>