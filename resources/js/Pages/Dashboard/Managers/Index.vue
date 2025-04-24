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
import { Edit, Trash2, UserPlus } from 'lucide-vue-next';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
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

const props = defineProps({
  managers: Array
});

const toast = useToast();

function deleteManager(managerId) {
  router.delete(route('managers.destroy', managerId), {
    onSuccess: () => {
      toast.success('Manager deleted successfully');
    },
    onError: () => {
      toast.error('Failed to delete manager');
    }
  });
}
</script>

<template>
  <Head title="Manage Managers" />
  
  <DashboardLayout>
    <div class="p-6 space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold">Manage Managers</h1>
          <p class="text-muted-foreground">Create and manage hotel managers</p>
        </div>
        
        <Link :href="route('managers.create')">
          <Button class="gap-2">
            <UserPlus class="h-4 w-4" />
            Add Manager
          </Button>
        </Link>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableCaption>List of all managers</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Avatar</TableHead>
              <TableHead>Name</TableHead>
              <TableHead>Email</TableHead>
              <TableHead>National ID</TableHead>
              <TableHead>Created At</TableHead>
              <TableHead class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="manager in managers" :key="manager.id">
              <TableCell>
                <img 
                  :src="manager.avatar_url || '/images/default-avatar.jpg'" 
                  alt="Avatar" 
                  class="w-10 h-10 rounded-full object-cover"
                />
              </TableCell>
              <TableCell class="font-medium">{{ manager.name }}</TableCell>
              <TableCell>{{ manager.email }}</TableCell>
              <TableCell>{{ manager.national_id }}</TableCell>
              <TableCell>{{ new Date(manager.created_at).toLocaleDateString() }}</TableCell>
              <TableCell class="text-right">
                <div class="flex justify-end gap-2">
                  <Link :href="route('managers.edit', manager.id)">
                    <Button variant="outline" size="sm">
                      <Edit class="h-4 w-4" />
                    </Button>
                  </Link>
                  
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button variant="outline" size="sm" class="text-destructive">
                        <Trash2 class="h-4 w-4" />
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>Delete Manager</AlertDialogTitle>
                        <AlertDialogDescription>
                          Are you sure you want to delete this manager? This action cannot be undone.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="deleteManager(manager.id)" class="bg-destructive text-destructive-foreground">
                          Delete
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
                </div>
              </TableCell>
            </TableRow>
            <TableRow v-if="managers.length === 0">
              <TableCell colspan="6" class="text-center py-8 text-muted-foreground">
                No managers found. Create one to get started.
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </DashboardLayout>
</template>