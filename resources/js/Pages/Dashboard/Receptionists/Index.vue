<script setup>
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle
} from "@/components/ui/alert-dialog";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow
} from "@/components/ui/table";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Trash2, UserPlus } from 'lucide-vue-next';
import { ref } from 'vue';
import { useToast } from "vue-toastification";

const props = defineProps({
  receptionists: Object,
});

const toast = useToast();
const showDeleteDialog = ref(false);
const receptionistToDelete = ref(null);

const openDeleteDialog = (receptionist) => {
  receptionistToDelete.value = receptionist;
  showDeleteDialog.value = true;
};

const confirmDelete = () => {
  if (!receptionistToDelete.value) return;
  
  router.delete(route('dashboard.receptionists.destroy', receptionistToDelete.value.id), {
    onSuccess: () => {
      toast.success('Receptionist deleted successfully');
      showDeleteDialog.value = false;
      receptionistToDelete.value = null;
    },
    onError: () => {
      toast.error('Failed to delete receptionist');
    }
  });
};

const cancelDelete = () => {
  showDeleteDialog.value = false;
  receptionistToDelete.value = null;
};
</script>

<template>
  <Head title="Manage Receptionists" />
  <DashboardLayout>
    <div class="p-6 space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold tracking-tight">Manage Receptionists</h1>
          <p class="text-muted-foreground">View and manage all receptionists in the system</p>
        </div>
        <Link :href="route('dashboard.receptionists.create')" class="flex items-center">
          <Button class="flex items-center gap-2">
            <UserPlus class="h-4 w-4" />
            Add New Receptionist
          </Button>
        </Link>
      </div>

      <div class="rounded-md border">
        <Table>
          <TableCaption>A list of all receptionists in the system</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Name</TableHead>
              <TableHead>Email</TableHead>
              <TableHead>National ID</TableHead>
              <TableHead>Status</TableHead>
              <TableHead class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="receptionist in receptionists.data" :key="receptionist.id" class="hover:bg-muted/50">
              <TableCell class="font-medium">{{ receptionist.name }}</TableCell>
              <TableCell>{{ receptionist.email }}</TableCell>
              <TableCell>{{ receptionist.national_id || 'N/A' }}</TableCell>
              <TableCell>
                <Badge :variant="receptionist.banned_at ? 'destructive' : 'success'">
                  {{ receptionist.banned_at ? 'Banned' : 'Active' }}
                </Badge>
              </TableCell>
              <TableCell class="text-right">
                <div class="flex justify-end gap-2">
                  <Link :href="route('dashboard.receptionists.edit', receptionist.id)">
                    <Button variant="outline" size="sm" class="h-8 w-8 p-0">
                      <Edit class="h-4 w-4" />
                      <span class="sr-only">Edit</span>
                    </Button>
                  </Link>
                  <Button 
                    @click="openDeleteDialog(receptionist)" 
                    variant="outline" 
                    size="sm" 
                    class="h-8 w-8 p-0 text-red-500 hover:text-red-600"
                  >
                    <Trash2 class="h-4 w-4" />
                    <span class="sr-only">Delete</span>
                  </Button>
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
      
      <!-- Pagination will go here if needed -->
    </div>

    <!-- Alert Dialog for Delete Confirmation -->
    <AlertDialog :open="showDeleteDialog" @update:open="showDeleteDialog = $event">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Warning: Delete Receptionist</AlertDialogTitle>
          <AlertDialogDescription>
            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-2 text-destructive">
                <span class="text-red-500">⚠️</span>
                <span class="font-semibold">This action cannot be undone!</span>
              </div>
              <p v-if="receptionistToDelete">
                You are about to permanently delete <strong>{{ receptionistToDelete.name }}</strong>'s account and all associated data.
              </p>
              <p>Are you absolutely sure you want to proceed?</p>
            </div>
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel @click="cancelDelete">Cancel</AlertDialogCancel>
          <AlertDialogAction @click="confirmDelete" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
            Yes, Delete
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </DashboardLayout>
</template>