<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTheme } from "@/composables/useTheme";
import { 
  Users, 
  CheckSquare,
  Calendar, 
  Settings,
  LogOut,
  Hotel, 
  User
} from 'lucide-vue-next';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  
} from "@/components/ui/dropdown-menu";

// Import table components
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Button } from "@/components/ui/button";

const { theme, toggleTheme } = useTheme();
const props = defineProps({
    approvedClients: Object
});
</script>

<template>
  <Head title="My Approved Clients" />

  <div class="flex h-screen" :class="theme === 'dark' ? 'bg-gray-900' : 'bg-gray-100'">
    <!-- Sidebar -->
    <div :class="[
      'w-64 border-r flex flex-col',
      theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'
    ]">
      <div :class="[
        'p-4 border-b',
        theme === 'dark' ? 'border-gray-700' : 'border-gray-200'
      ]">
        <h1 class="text-xl font-semibold flex items-center" :class="theme === 'dark' ? 'text-white' : ''">
            <Hotel class="mr-3 h-5 w-5 text-primary" />
          <span class="mr-2">Hotel Management</span>
        </h1>
      </div>
      
      <!-- Receptionist Navigation -->
      <nav class="flex-1 overflow-y-auto py-4">
        <Link :href="route('receptionist.pending-clients')" :class="[
          'flex items-center px-4 py-3 text-sm font-medium',
          theme === 'dark' 
            ? 'text-gray-300 hover:bg-gray-700 hover:text-white' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-black-600'
        ]">
          <Users class="mr-3 h-5 w-5" />
          Pending Clients
        </Link>
        <Link :href="route('receptionist.approved-clients')" :class="[
          'flex items-center px-4 py-3 text-sm font-medium',
          theme === 'dark' 
            ? 'bg-gray-700 text-white' 
            : 'bg-gray-100 text-black-600'
        ]">
          <CheckSquare class="mr-3 h-5 w-5" />
          My Approved Clients
        </Link>
        <Link :href="route('receptionist.clients-reservations')" :class="[
          'flex items-center px-4 py-3 text-sm font-medium',
          theme === 'dark' 
            ? 'text-gray-300 hover:bg-gray-700 hover:text-white' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-black-600'
        ]">
          <Calendar class="mr-3 h-5 w-5" />
          Client Reservations
        </Link>
        
        <div :class="[
          'mt-auto pt-4 border-t',
          theme === 'dark' ? 'border-gray-700' : 'border-gray-200'
        ]">
          <Link :href="route('logout')" as="button" method="post" :class="[
            'flex items-center px-4 py-3 text-sm font-medium w-full text-left',
            theme === 'dark' 
              ? 'text-gray-300 hover:bg-gray-700 hover:text-white' 
              : 'text-gray-600 hover:bg-gray-50 hover:text-black-600'
          ]">
            <LogOut class="mr-3 h-5 w-5" />
            Logout
          </Link>
        </div>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header :class="[
        'border-b p-4 flex items-center justify-between',
        theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'
      ]">
<br>

        <div class="flex items-center space-x-4">    
          <!-- Theme Toggle -->
          <button :class="[
            'p-1 rounded-full focus:outline-none',
            theme === 'dark' ? 'text-gray-300 hover:text-white' : 'text-gray-400 hover:text-gray-500'
          ]" @click="toggleTheme">
            <span v-if="theme === 'dark'" class="sr-only">Switch to light mode</span>
            <span v-else class="sr-only">Switch to dark mode</span>
            <svg v-if="theme === 'dark'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
          </button>

          <!-- User menu -->
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" size="icon" class="rounded-full">
                <Settings class="['p-1 rounded-full focus:outline-none',theme === 'dark' ? 'text-gray-300 hover:text-white' : 'text-gray-400 hover:text-gray-500']" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              <Separator />
              <DropdownMenuItem>
                <Link class="w-full flex items-center">
                  <User class="mr-2 h-4 w-4" />
                  <span>Profile</span>
                </Link>
              </DropdownMenuItem>
              <Separator />
              <DropdownMenuItem>
                <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center text-destructive">
                  <LogOut class="mr-2 h-4 w-4" />
                  <span>Log out</span>
                </Link>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </header>

      <!-- Page Content -->
      <div :class="[
        'border-b p-4 rounded m-3',
        theme === 'dark' ? 'bg-gray-800 border-gray-700 text-white' : 'bg-white border-gray-200'
      ]">
        <h2 class="text-xl font-semibold">My Approved Clients</h2>
        <p :class="[
          'text-sm',
          theme === 'dark' ? 'text-gray-400' : 'text-gray-500'
        ]">Manage clients you have approved</p>
      </div>

      <main :class="[
        'flex-1 overflow-y-auto p-6',
        theme === 'dark' ? 'bg-gray-900' : 'bg-gray-100'
      ]">
        <!-- Approved Clients Table Section -->
        <div :class="[
          'rounded-lg shadow overflow-hidden mb-6',
          theme === 'dark' ? 'bg-gray-800' : 'bg-white'
        ]">
          <div class="p-6">
            <Table>
              <TableCaption :class="theme === 'dark' ? 'text-gray-400' : ''">Clients you have approved</TableCaption>
              <TableHeader>
                <TableRow :class="theme === 'dark' ? 'border-gray-700' : ''">
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Name</TableHead>
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Email</TableHead>
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Mobile</TableHead>
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Country</TableHead>
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Gender</TableHead>
                  <TableHead :class="theme === 'dark' ? 'text-gray-300' : ''">Approval Date</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="client in approvedClients.data" :key="client.id" :class="theme === 'dark' ? 'border-gray-700' : ''">
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ client.name }}</TableCell>
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ client.email }}</TableCell>
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ client.mobile ? client.mobile : 'N/A' }}</TableCell>
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ client.country_code ? client.country_code : 'N/A' }}</TableCell>
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ client.gender ? client.gender : 'N/A' }}</TableCell>
                  <TableCell :class="theme === 'dark' ? 'text-gray-300' : ''">{{ new Date(client.approved_at).toLocaleDateString() }}</TableCell>
                </TableRow>
                <TableRow v-if="approvedClients.data.length === 0" :class="theme === 'dark' ? 'border-gray-700' : ''">
                  <TableCell colspan="6" class="text-center" :class="theme === 'dark' ? 'text-gray-300' : ''">No approved clients found</TableCell>
                </TableRow>
              </TableBody>
            </Table>

            <!-- Pagination Controls -->
            <div class="flex items-center justify-between space-x-6 mt-4">
            <div :class="[
                'text-sm',
                theme === 'dark' ? 'text-gray-400' : 'text-gray-500'
            ]">
                <!-- Simple record count display -->
                Total: {{ approvedClients.total || approvedClients.data.length }} records
            </div>
            
            <div class="flex items-center space-x-1">
                <!-- Simpler pagination controls that will work with minimal data -->
                <Button 
                variant="outline" 
                size="sm" 
                :disabled="(approvedClients.current_page || 1) <= 1" 
                @click="goToPage((approvedClients.current_page || 1) - 1)"
                :class="[
                    theme === 'dark' ? 'bg-gray-700 text-gray-300 border-gray-600' : '',
                    'px-2'
                ]"
                >
                <ChevronLeft class="h-4 w-4" /> Previous
                </Button>
                
                <!-- Show current page / total pages -->
                <span :class="theme === 'dark' ? 'text-gray-300' : ''" class="px-2">
                Page {{ approvedClients.current_page || 1 }} of {{ approvedClients.last_page || 1 }}
                </span>
                
                <Button 
                variant="outline" 
                size="sm" 
                :disabled="!(approvedClients.next_page_url) || (approvedClients.current_page || 1) >= (approvedClients.last_page || 1)" 
                @click="goToPage((approvedClients.current_page || 1) + 1)"
                :class="[
                    theme === 'dark' ? 'bg-gray-700 text-gray-300 border-gray-600' : '',
                    'px-2'
                ]"
                >
                Next <ChevronRight class="h-4 w-4" />
                </Button>
            </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions Section -->
        <div :class="[
          'rounded-lg shadow overflow-hidden',
          theme === 'dark' ? 'bg-gray-800' : 'bg-white'
        ]">
          <div class="p-6">
            <h3 class="text-lg font-semibold mb-4" :class="theme === 'dark' ? 'text-white' : ''">Quick Actions</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <Link :href="route('receptionist.pending-clients')" :class="[
                'flex items-center justify-center py-4 px-6 rounded-lg transition-colors',
                theme === 'dark' 
                  ? 'bg-gray-700 hover:bg-gray-600 text-white' 
                  : 'bg-gray-100 hover:bg-gray-200'
              ]">
                <Users :class="[
                  'h-6 w-6 mr-3',
                  theme === 'dark' ? 'text-gray-300' : 'text-black-600'
                ]" />
                <span class="font-medium">Pending Clients</span>
              </Link>
              <Link :href="route('receptionist.clients-reservations')" :class="[
                'flex items-center justify-center py-4 px-6 rounded-lg transition-colors',
                theme === 'dark' 
                  ? 'bg-gray-700 hover:bg-gray-600 text-white' 
                  : 'bg-gray-100 hover:bg-gray-200'
              ]">
                <Calendar :class="[
                  'h-6 w-6 mr-3',
                  theme === 'dark' ? 'text-gray-300' : 'text-black-600'
                ]" />
                <span class="font-medium">Client Reservations</span>
              </Link>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>