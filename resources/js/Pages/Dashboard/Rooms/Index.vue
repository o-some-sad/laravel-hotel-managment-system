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
import { Edit, Trash2 } from 'lucide-vue-next';
import { useToast } from "vue-toastification";
import { useConfirm } from "@/composables/useConfirm";
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
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
  rooms: Array,
  isAdmin: Boolean,
  userId: Number
});

const { toast } = useToast();
const { confirm } = useConfirm();

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
</script>

<template>
  <Head title="Manage Rooms" />
  <DashboardLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold tracking-tight">Manage Rooms</h1>
        <Link :href="route('rooms.create')">
          <Button>Add New Room</Button>
        </Link>
      </div>
      
      <div class="rounded-md border">
        <Table>
          <TableCaption>List of all rooms</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Room Number</TableHead>
              <TableHead>Capacity</TableHead>
              <TableHead>Price</TableHead>
              <TableHead>Floor</TableHead>
              <TableHead v-if="isAdmin">Manager</TableHead>
              <TableHead v-if="isAdmin || rooms.some(room => room.created_by === userId)" class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="room in rooms" :key="room.id">
              <TableCell class="font-medium">{{ room.number }}</TableCell>
              <TableCell>{{ room.capacity }}</TableCell>
              <TableCell>{{ formatPrice(room.price) }}</TableCell>
              <TableCell>{{ room.floor.name }}</TableCell>
              <TableCell v-if="isAdmin">{{ room.creator.name }}</TableCell>
              <TableCell v-if="canManageRoom(room)" class="text-right">
                <div class="flex justify-end gap-2">
                  <Link :href="route('rooms.edit', room.id)">
                    <Button variant="outline" size="sm">
                      <Edit class="h-4 w-4" />
                    </Button>
                  </Link>
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button variant="destructive" size="sm">
                        <Trash2 class="h-4 w-4" />
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
      </div>
    </div>
  </DashboardLayout>
</template>