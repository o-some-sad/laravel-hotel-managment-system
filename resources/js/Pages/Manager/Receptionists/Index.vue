<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
      <h2 class="text-3xl font-bold tracking-tight">Manage Receptionists</h2>
      <Button as="a" href="/manager/receptionists/create">
        Add Receptionist
      </Button>
    </div>

    <!-- Receptionists Table -->
    <Card>
      <CardHeader>
        <CardTitle>Receptionists</CardTitle>
        <CardDescription>List of all receptionists managed by you.</CardDescription>
      </CardHeader>
      <CardContent>
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
                <Button as="a" :href="`/manager/receptionists/${receptionist.id}/edit`" size="sm">
                  Edit
                </Button>
                <Button @click="deleteReceptionist(receptionist.id)" variant="destructive" size="sm">
                  Delete
                </Button>
                <Button @click="toggleBan(receptionist.id)" size="sm">
                  {{ receptionist.banned_at ? 'Unban' : 'Ban' }}
                </Button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </CardContent>
      <CardFooter>
        <Pagination :links="receptionists.links" />
      </CardFooter>
    </Card>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Pagination } from '@/components/ui/pagination';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

const props = defineProps({
  receptionists: Object,
});

const deleteReceptionist = (id) => {
  if (confirm('Are you sure you want to delete this receptionist?')) {
    router.delete(`/manager/receptionists/${id}`);
  }
};

const toggleBan = (id) => {
  router.post(`/manager/receptionists/${id}/toggle-ban`, {}, {
    onSuccess: () => {
      router.reload({ only: ['receptionists'] });
    },
  });
};
</script>