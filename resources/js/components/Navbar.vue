<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { useTheme } from "@/composables/useTheme";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import {
  Sheet,
  SheetContent,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
  SheetClose,
} from "@/components/ui/sheet";
import { Sun, Moon, Menu, X } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';

const { theme, toggleTheme } = useTheme();
const isScrolled = ref(false);
const isOpen = ref(false);

const checkScroll = () => {
  isScrolled.value = window.scrollY > 10;
};

const closeSheet = () => {
  isOpen.value = false;
};

onMounted(() => {
  window.addEventListener('scroll', checkScroll);
  checkScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', checkScroll);
});

defineProps({
  auth: Object,
});
</script>

<template>
  <header 
    class="sticky top-0 z-50 w-full backdrop-blur transition-all duration-300"
    :class="[
      isScrolled ? 'bg-background/95 border-b shadow-sm' : 'bg-transparent'
    ]"
  >
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex h-16 items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center gap-2">
        <Link href="/" class="font-bold text-xl">Hotel Management</Link>
      </div>
      
      <!-- Desktop Navigation -->
      <nav class="hidden md:flex items-center gap-6">
        <Link href="/" class="text-sm font-medium transition-colors hover:text-primary">Home</Link>
        <Link href="/#services" class="text-sm font-medium transition-colors hover:text-primary">Services</Link>
        <Link href="/#testimonials" class="text-sm font-medium transition-colors hover:text-primary">Testimonials</Link>
        <Link href="/#contact" class="text-sm font-medium transition-colors hover:text-primary">Contact</Link>
      </nav>
      
      <div class="flex items-center gap-4">
        <!-- Theme Toggle -->
        <Button variant="ghost" size="icon" @click="toggleTheme" class="rounded-full">
          <Sun v-if="theme === 'dark'" class="h-5 w-5" />
          <Moon v-else class="h-5 w-5" />
          <span class="sr-only">Toggle theme</span>
        </Button>
        
        <!-- Desktop Auth Buttons -->
        <div class="hidden md:flex items-center gap-2">
          <template v-if="auth && auth.user">
            <DropdownMenu>
              <DropdownMenuTrigger as="div">
                <Button variant="outline" class="rounded-full">
                  {{ auth.user.name }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end" class="w-56">
                <DropdownMenuItem>
                  <Link :href="route('dashboard')" class="w-full flex items-center">
                    Dashboard
                  </Link>
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <Link :href="route('profile.edit')" class="w-full flex items-center">
                    Profile
                  </Link>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center text-destructive">
                    Log Out
                  </Link>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </template>
          <template v-else>
            <Link :href="route('login')">
              <Button variant="outline" class="rounded-full">Login</Button>
            </Link>
            <Link :href="route('register')">
              <Button class="rounded-full">Register</Button>
            </Link>
          </template>
        </div>
        
        <!-- Mobile Menu Button -->
        <Sheet v-model:open="isOpen">
          <SheetTrigger as-child>
            <Button variant="ghost" size="icon" class="md:hidden rounded-full">
              <Menu class="h-5 w-5" />
              <span class="sr-only">Open menu</span>
            </Button>
          </SheetTrigger>
          <SheetContent side="right" class="w-[280px] sm:w-[350px] fixed top-0 z-[100]">
            <div class="flex flex-col h-full">
              <SheetHeader class="mb-6">
                <SheetTitle>Hotel Management</SheetTitle>
              </SheetHeader>
              
              <div class="flex-1 overflow-y-auto">
                <nav class="flex flex-col space-y-4 mb-8">
                  <SheetClose as-child>
                    <Link href="/" class="flex items-center text-sm font-medium transition-colors hover:text-primary px-2 py-2 rounded-md hover:bg-muted">
                      Home
                    </Link>
                  </SheetClose>
                  <SheetClose as-child>
                    <Link href="#services" class="flex items-center text-sm font-medium transition-colors hover:text-primary px-2 py-2 rounded-md hover:bg-muted">
                      Services
                    </Link>
                  </SheetClose>
                  <SheetClose as-child>
                    <Link href="#testimonials" class="flex items-center text-sm font-medium transition-colors hover:text-primary px-2 py-2 rounded-md hover:bg-muted">
                      Testimonials
                    </Link>
                  </SheetClose>
                  <SheetClose as-child>
                    <Link href="#contact" class="flex items-center text-sm font-medium transition-colors hover:text-primary px-2 py-2 rounded-md hover:bg-muted">
                      Contact
                    </Link>
                  </SheetClose>
                </nav>
                
                <div class="border-t border-border pt-6">
                  <template v-if="auth && auth.user">
                    <div class="space-y-4">
                      <p class="text-sm font-medium px-2">Signed in as {{ auth.user.name }}</p>
                      <SheetClose as-child>
                        <Link :href="route('dashboard')">
                          <Button variant="outline" class="w-full justify-start">Dashboard</Button>
                        </Link>
                      </SheetClose>
                      <SheetClose as-child>
                        <Link :href="route('profile.edit')">
                          <Button variant="outline" class="w-full justify-start">Profile</Button>
                        </Link>
                      </SheetClose>
                      <SheetClose as-child>
                        <Link :href="route('logout')" method="post" as="button">
                          <Button variant="destructive" class="w-full justify-start">Log Out</Button>
                        </Link>
                      </SheetClose>
                    </div>
                  </template>
                  <template v-else>
                    <div class="space-y-4">
                      <SheetClose as-child>
                        <Link :href="route('login')">
                          <Button variant="outline" class="w-full">Login</Button>
                        </Link>
                      </SheetClose>
                      <SheetClose as-child>
                        <Link :href="route('register')">
                          <Button class="w-full">Register</Button>
                        </Link>
                      </SheetClose>
                    </div>
                  </template>
                </div>
              </div>
              
              <div class="mt-auto pt-4 border-t border-border">
                <div class="flex items-center justify-between">
                  <p class="text-sm text-muted-foreground">Switch theme</p>
                  <Button variant="ghost" size="icon" @click="toggleTheme" class="rounded-full">
                    <Sun v-if="theme === 'dark'" class="h-5 w-5" />
                    <Moon v-else class="h-5 w-5" />
                  </Button>
                </div>
              </div>
            </div>
          </SheetContent>
        </Sheet>
      </div>
    </div>
  </header>
</template>