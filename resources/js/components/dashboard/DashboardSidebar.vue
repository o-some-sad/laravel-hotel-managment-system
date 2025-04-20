<script setup>
import { ref } from 'vue';
import SidebarContent from './SidebarContent.vue';

const props = defineProps({
  activeTab: String,
  isMobileSidebarOpen: Boolean
});

const emit = defineEmits(['update:activeTab', 'close-mobile-sidebar']);

const setActiveTab = (tab) => {
  emit('update:activeTab', tab);
  if (props.isMobileSidebarOpen) {
    emit('close-mobile-sidebar');
  }
};

// Track open/closed state of each dropdown
const openSections = ref({
  admin: false,
  manager: false,
  receptionist: false
});

const toggleSection = (section) => {
  openSections.value[section] = !openSections.value[section];
};
</script>

<template>
  <!-- Desktop Sidebar -->
  <aside class="hidden md:flex w-64 flex-col border-r bg-card h-[calc(100vh-64px)]">
    <div class="flex flex-col gap-1 p-4 h-full overflow-y-auto">
      <SidebarContent 
        :activeTab="activeTab" 
        :openSections="openSections" 
        @update:activeTab="setActiveTab" 
        @toggle-section="toggleSection" 
      />
    </div>
  </aside>

  <!-- Mobile Sidebar -->
  <div 
    v-if="isMobileSidebarOpen" 
    class="fixed inset-0 z-50 bg-background/80 backdrop-blur-sm md:hidden"
    @click="emit('close-mobile-sidebar')"
  >
    <div 
      class="fixed inset-y-0 left-0 w-64 bg-card border-r overflow-hidden h-full"
      @click.stop
    >
      <div class="p-4 h-full overflow-y-auto">
        <SidebarContent 
          :activeTab="activeTab" 
          :openSections="openSections" 
          @update:activeTab="setActiveTab" 
          @toggle-section="toggleSection" 
        />
      </div>
    </div>
  </div>
</template>