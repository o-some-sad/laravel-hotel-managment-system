<script setup>
import { Button } from "@/components/ui/button";
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";
import {
  BarChart3,
  Bed,
  Building,
  Calendar,
  ChevronDown,
  ClipboardList,
  DollarSign,
  Home,
  Hotel,
  Key,
  Shield,
  User,
  UserCog,
  Users
} from 'lucide-vue-next';

const props = defineProps({
  activeTab: String,
  openSections: Object
});

const emit = defineEmits(['update:activeTab', 'toggle-section']);

const setActiveTab = (tab) => {
  emit('update:activeTab', tab);
};

const toggleSection = (section) => {
  emit('toggle-section', section);
};
</script>

<template>
  <div class="flex flex-col gap-1">
    <!-- Dashboard Home -->
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'dashboard' }"
      @click="setActiveTab('dashboard')"
    >
      <Home class="h-4 w-4" />
      <span>Dashboard</span>
    </Button>
    
    <!-- Admin Section -->
    <Collapsible class="w-full">
      <CollapsibleTrigger asChild>
        <Button 
          variant="ghost" 
          class="justify-between w-full px-2 group"
        >
          <div class="flex items-center gap-2">
            <Shield class="h-4 w-4" />
            <span>Admin</span>
          </div>
          <ChevronDown 
            class="h-4 w-4 transition-transform" 
            :class="{ 'transform rotate-180': openSections.admin }"
            @click.stop="toggleSection('admin')"
          />
        </Button>
      </CollapsibleTrigger>
      <CollapsibleContent class="pl-6 space-y-1">
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'admin-users' }"
          @click="setActiveTab('admin-users')"
        >
          <Users class="h-4 w-4" />
          <span>Users Management</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'admin-roles' }"
          @click="setActiveTab('admin-roles')"
        >
          <UserCog class="h-4 w-4" />
          <span>Roles & Permissions</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'admin-floors' }"
          @click="setActiveTab('admin-floors')"
        >
          <Building class="h-4 w-4" />
          <span>Floors Management</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'admin-rooms' }"
          @click="setActiveTab('admin-rooms')"
        >
          <Hotel class="h-4 w-4" />
          <span>Rooms Management</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'admin-reports' }"
          @click="setActiveTab('admin-reports')"
        >
          <BarChart3 class="h-4 w-4" />
          <span>System Reports</span>
        </Button>
      </CollapsibleContent>
    </Collapsible>
    
    <!-- Manager Section -->
    <Collapsible class="w-full">
      <CollapsibleTrigger asChild>
        <Button 
          variant="ghost" 
          class="justify-between w-full px-2 group"
        >
          <div class="flex items-center gap-2">
            <UserCog class="h-4 w-4" />
            <span>Manager</span>
          </div>
          <ChevronDown 
            class="h-4 w-4 transition-transform" 
            :class="{ 'transform rotate-180': openSections.manager }"
            @click.stop="toggleSection('manager')"
          />
        </Button>
      </CollapsibleTrigger>
      <CollapsibleContent class="pl-6 space-y-1">
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'manager-bookings' }"
          @click="setActiveTab('manager-bookings')"
        >
          <Calendar class="h-4 w-4" />
          <span>Bookings</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'manager-rooms' }"
          @click="setActiveTab('manager-rooms')"
        >
          <Bed class="h-4 w-4" />
          <span>Manage Rooms</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'manager-guests' }"
          @click="setActiveTab('manager-guests')"
        >
          <Users class="h-4 w-4" />
          <span>Guests</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'manager-staff' }"
          @click="setActiveTab('manager-staff')"
        >
          <User class="h-4 w-4" />
          <span>Staff Management</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'manager-reports' }"
          @click="setActiveTab('manager-reports')"
        >
          <BarChart3 class="h-4 w-4" />
          <span>Financial Reports</span>
        </Button>
      </CollapsibleContent>
    </Collapsible>
    
    <!-- Receptionist Section -->
    <Collapsible class="w-full">
      <CollapsibleTrigger asChild>
        <Button 
          variant="ghost" 
          class="justify-between w-full px-2 group"
        >
          <div class="flex items-center gap-2">
            <ClipboardList class="h-4 w-4" />
            <span>Receptionist</span>
          </div>
          <ChevronDown 
            class="h-4 w-4 transition-transform" 
            :class="{ 'transform rotate-180': openSections.receptionist }"
            @click.stop="toggleSection('receptionist')"
          />
        </Button>
      </CollapsibleTrigger>
      <CollapsibleContent class="pl-6 space-y-1">
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'receptionist-checkin' }"
          @click="setActiveTab('receptionist-checkin')"
        >
          <Key class="h-4 w-4" />
          <span>Check-in/Check-out</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'receptionist-bookings' }"
          @click="setActiveTab('receptionist-bookings')"
        >
          <Calendar class="h-4 w-4" />
          <span>Manage Bookings</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'receptionist-guests' }"
          @click="setActiveTab('receptionist-guests')"
        >
          <Users class="h-4 w-4" />
          <span>Guest Management</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'receptionist-rooms' }"
          @click="setActiveTab('receptionist-rooms')"
        >
          <Hotel class="h-4 w-4" />
          <span>Room Availability</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'receptionist-payments' }"
          @click="setActiveTab('receptionist-payments')"
        >
          <DollarSign class="h-4 w-4" />
          <span>Payments</span>
        </Button>
      </CollapsibleContent>
    </Collapsible>
  </div>
</template>