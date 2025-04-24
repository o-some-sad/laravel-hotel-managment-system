<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { 
  Table, 
  TableBody, 
  TableCaption, 
  TableCell, 
  TableHead, 
  TableHeader, 
  TableRow 
} from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Edit, Trash2, Plus } from 'lucide-vue-next';
import { useToast } from "vue-toastification";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import {
  Pagination,
  PaginationList,
  PaginationListItem,
  PaginationFirst,
  PaginationLast,
  PaginationNext,
  PaginationPrev,
  PaginationEllipsis,
} from "@/components/ui/pagination";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
  rooms: Object, // Changed to Object to handle pagination data
  isAdmin: Boolean,
  userId: Number
});

const { toast } = useToast();

const formatPrice = (cents) => {
  return `$${(cents / 100).toFixed(2)}`;
};

const deleteRoom = (room) => {
  router.delete(route('rooms.destroy', room.id), {
    onSuccess: () => {
      toast({
        title: 'Room deleted',
        description: 'The room has been deleted successfully'
      });
    }
  });
};

const canManageRoom = (room) => {
  return props.isAdmin || room.created_by === props.userId;
};

// Handle pagination
const goToPage = (page) => {
  router.get(route('rooms.index', { page }));
};
</script>

<template>
  <Head title="Manage Rooms" />
  <DashboardLayout>
    <div class="container mx-auto py-6 space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold tracking-tight">Rooms</h1>
          <p class="text-muted-foreground">Manage your hotel rooms inventory</p>
        </div>
        <Link :href="route('rooms.create')">
          <Button class="flex items-center gap-2">
            <Plus class="h-4 w-4" />
            <span>Add New Room</span>
          </Button>
        </Link>
      </div>
      
      <div class="rounded-md border bg-card">
        <Table>
          <TableCaption v-if="rooms.data.length === 0">No rooms available.</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Room Number</TableHead>
              <TableHead>Capacity</TableHead>
              <TableHead>Price</TableHead>
              <TableHead>Floor</TableHead>
              <TableHead v-if="isAdmin">Manager</TableHead>
              <TableHead v-if="isAdmin || rooms.data.some(room => room.created_by === userId)" class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="room in rooms.data" :key="room.id" class="hover:bg-muted/50">
              <TableCell class="font-medium">{{ room.number }}</TableCell>
              <TableCell>{{ room.capacity }}</TableCell>
              <TableCell>{{ formatPrice(room.price) }}</TableCell>
              <TableCell>{{ room.floor.name }}</TableCell>
              <TableCell v-if="isAdmin">{{ room.creator.name }}</TableCell>
              <TableCell v-if="canManageRoom(room)" class="text-right">
                <div class="flex justify-end gap-2">
                  <Link :href="route('rooms.edit', room.id)">
                    <Button variant="outline" size="sm" class="h-8 w-8 p-0">
                      <Edit class="h-4 w-4" />
                      <span class="sr-only">Edit</span>
                    </Button>
                  </Link>
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button variant="destructive" size="sm" class="h-8 w-8 p-0">
                        <Trash2 class="h-4 w-4" />
                        <span class="sr-only">Delete</span>
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>Delete Room</AlertDialogTitle>
                        <AlertDialogDescription>
                          Are you sure you want to delete room {{ room.number }}? This action cannot be undone.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="deleteRoom(room)">Delete</AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
        
        <!-- Pagination -->
        <div class="flex items-center justify-between px-2 py-4 border-t">
          <Pagination v-if="rooms.links && rooms.links.length > 3">
            <PaginationList class="flex items-center gap-1">
              <PaginationListItem v-if="rooms.prev_page_url">
                <PaginationFirst @click.prevent="goToPage(1)" />
              </PaginationListItem>
              
              <PaginationListItem v-if="rooms.prev_page_url">
                <PaginationPrev @click.prevent="goToPage(rooms.current_page - 1)" />
              </PaginationListItem>
              
              <template v-for="(link, i) in rooms.links" :key="i">
                <PaginationListItem v-if="i !== 0 && i !== rooms.links.length - 1">
                  <Button 
                    variant="outline" 
                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                    class="h-9 w-9"
                    @click.prevent="goToPage(link.label)"
                  >
                    {{ link.label }}
                  </Button>
                </PaginationListItem>
              </template>
              
              <PaginationListItem v-if="rooms.next_page_url">
                <PaginationNext @click.prevent="goToPage(rooms.current_page + 1)" />
              </PaginationListItem>
              
              <PaginationListItem v-if="rooms.next_page_url">
                <PaginationLast @click.prevent="goToPage(rooms.last_page)" />
              </PaginationListItem>
            </PaginationList>
          </Pagination>
          
          <div class="text-sm text-muted-foreground">
            Showing {{ rooms.from || 0 }} to {{ rooms.to || 0 }} of {{ rooms.total }} rooms
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>