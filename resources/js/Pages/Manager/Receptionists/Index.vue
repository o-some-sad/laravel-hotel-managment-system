<script setup>
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import { Pagination,PaginationNext,PaginationPrev } from '@/components/ui/pagination' 
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  receptionists: {type: Object,required: true,default: () => ({ 
      data: [],
      links: []
    })
  }
})
console.log('Receptionists Data:', props.receptionists)
</script>

<template>
   <div class="space-y-4">
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead>Name</TableHead>
        <TableHead>Email</TableHead>
        <TableHead>Actions</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow 
        v-for="receptionist in receptionists.data":key="receptionist.id">
        <TableCell>{{ receptionist.name }}</TableCell>
        <TableCell>{{ receptionist.email }}</TableCell>
        <TableCell>{{ receptionist.creator?.name || 'System' }}</TableCell>
      </TableRow>
    </TableBody>
  </Table>
  <Pagination :links="receptionists.links">
    <PaginationPrev />
    <PaginationNext />
  </Pagination>
</div>
</template>