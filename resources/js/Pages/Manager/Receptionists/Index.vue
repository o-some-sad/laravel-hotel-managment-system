<template>
  <div class="space-y-6">
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead>Name</TableHead>
          <TableHead>Email</TableHead>
          <TableHead>Status</TableHead>
          <TableHead>Actions</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="receptionist in receptionists.data" :key="receptionist.id">
          <TableCell>{{ receptionist.name }}</TableCell>
          <TableCell>{{ receptionist.email }}</TableCell>
          <TableCell>
            <Badge :variant="receptionist.banned_at ? 'destructive' : 'success'">
              {{ receptionist.banned_at ? 'Banned' : 'Active' }}
            </Badge>
          </TableCell>
          <TableCell class="flex gap-2">
            <Link :href="`/manager/receptionists/${receptionist.id}/edit`" class="px-2 py-1 text-sm bg-blue-500 text-white rounded">Edit</Link>
            <Button @click="deleteReceptionist(receptionist.id)" variant="destructive">Delete</Button>
            <Button @click="toggleBan(receptionist.id)">
              {{ receptionist.banned_at ? 'Unban' : 'Ban' }}
            </Button>
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
    <Pagination :links="receptionists.links" />
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Pagination from '@/components/ui/pagination';
import Badge from '@/components/ui/badge';
import Button from '@/components/ui/button';

const props = defineProps({
  receptionists: Object
});

const deleteReceptionist = (id) => {
  if (confirm('Are you sure you want to delete this receptionist?')) {
    Inertia.delete(`/manager/receptionists/${id}`);
  }
};

const toggleBan = (id) => {
  Inertia.post(`/manager/receptionists/${id}/toggle-ban`);
};
</script>