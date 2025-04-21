<script setup>
import { Button } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";
import { 
  Home, 
  User, 
  Hotel, 
  Calendar, 
  CreditCard, 
  MessageSquare,
  Settings,
  ChevronDown,
  Heart,
  History,
  Receipt,
  Star,
  HelpCircle
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
    
    <!-- Bookings Section -->
    <Collapsible class="w-full">
      <CollapsibleTrigger asChild>
        <Button 
          variant="ghost" 
          class="justify-between w-full px-2 group"
        >
          <div class="flex items-center gap-2">
            <Calendar class="h-4 w-4" />
            <span>My Bookings</span>
          </div>
          <ChevronDown 
            class="h-4 w-4 transition-transform" 
            :class="{ 'transform rotate-180': openSections.bookings }"
            @click.stop="toggleSection('bookings')"
          />
        </Button>
      </CollapsibleTrigger>
      <CollapsibleContent class="pl-6 space-y-1">
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'active-bookings' }"
          @click="setActiveTab('active-bookings')"
        >
          <Calendar class="h-4 w-4" />
          <span>Active Bookings</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'booking-history' }"
          @click="setActiveTab('booking-history')"
        >
          <History class="h-4 w-4" />
          <span>Booking History</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'new-booking' }"
          @click="setActiveTab('new-booking')"
        >
          <Hotel class="h-4 w-4" />
          <span>New Booking</span>
        </Button>
      </CollapsibleContent>
    </Collapsible>
    
    <!-- Account Section -->
    <Collapsible class="w-full">
      <CollapsibleTrigger asChild>
        <Button 
          variant="ghost" 
          class="justify-between w-full px-2 group"
        >
          <div class="flex items-center gap-2">
            <User class="h-4 w-4" />
            <span>My Account</span>
          </div>
          <ChevronDown 
            class="h-4 w-4 transition-transform" 
            :class="{ 'transform rotate-180': openSections.account }"
            @click.stop="toggleSection('account')"
          />
        </Button>
      </CollapsibleTrigger>
      <CollapsibleContent class="pl-6 space-y-1">
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'profile' }"
          @click="setActiveTab('profile')"
        >
          <User class="h-4 w-4" />
          <span>Profile</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'payment-methods' }"
          @click="setActiveTab('payment-methods')"
        >
          <CreditCard class="h-4 w-4" />
          <span>Payment Methods</span>
        </Button>
        <Button 
          variant="ghost" 
          class="justify-start gap-2 px-2 w-full" 
          :class="{ 'bg-accent': activeTab === 'preferences' }"
          @click="setActiveTab('preferences')"
        >
          <Settings class="h-4 w-4" />
          <span>Preferences</span>
        </Button>
      </CollapsibleContent>
    </Collapsible>
    
    <!-- Common features -->
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'favorites' }"
      @click="setActiveTab('favorites')"
    >
      <Heart class="h-4 w-4" />
      <span>Favorites</span>
    </Button>
    
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'invoices' }"
      @click="setActiveTab('invoices')"
    >
      <Receipt class="h-4 w-4" />
      <span>Invoices</span>
    </Button>
    
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'reviews' }"
      @click="setActiveTab('reviews')"
    >
      <Star class="h-4 w-4" />
      <span>My Reviews</span>
    </Button>
    
    <Separator class="my-2" />
    
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'messages' }"
      @click="setActiveTab('messages')"
    >
      <MessageSquare class="h-4 w-4" />
      <span>Messages</span>
    </Button>
    
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'help' }"
      @click="setActiveTab('help')"
    >
      <HelpCircle class="h-4 w-4" />
      <span>Help & Support</span>
    </Button>
    
    <Button 
      variant="ghost" 
      class="justify-start gap-2 px-2" 
      :class="{ 'bg-accent': activeTab === 'settings' }"
      @click="setActiveTab('settings')"
    >
      <Settings class="h-4 w-4" />
      <span>Settings</span>
    </Button>
  </div>
</template>