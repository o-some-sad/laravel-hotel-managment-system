<script setup>
import { Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
// import { 
//   Pagination, 
//   PaginationContent, 
//   PaginationItem, 
//   PaginationLink, 
//   PaginationNext, 
//   PaginationPrevious 
// } from "@/components/ui/pagination";

const props = defineProps({
    reservations: Object
});
</script>

<template>
    <Head title="Clients Reservations" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clients Reservations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table>
                            <TableCaption>Reservations for clients you have approved</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Client Name</TableHead>
                                    <TableHead>Accompany Number</TableHead>
                                    <TableHead>Room Number</TableHead>
                                    <TableHead>Paid Price</TableHead>
                                    <TableHead>Reservation Date</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="reservation in reservations.data" :key="reservation.id">
                                    <TableCell>{{ reservation.client.name }}</TableCell>
                                    <TableCell>{{ reservation.accompany_number }}</TableCell>
                                    <TableCell>{{ reservation.room.number }}</TableCell>
                                    <TableCell>${{ (reservation.paid_price / 100).toFixed(2) }}</TableCell>
                                    <TableCell>{{ new Date(reservation.created_at).toLocaleDateString() }}</TableCell>
                                </TableRow>
                                <TableRow v-if="reservations.data.length === 0">
                                    <TableCell colspan="5" class="text-center">No reservations found</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        
                        <!-- <Pagination v-if="reservations.data.length > 0" class="mt-4">
                            <PaginationContent>
                                <PaginationItem v-if="reservations.prev_page_url">
                                    <PaginationPrevious :href="reservations.prev_page_url" />
                                </PaginationItem>
                                
                                <PaginationItem v-for="page in reservations.links.slice(1, -1)" :key="page.label">
                                    <PaginationLink :href="page.url" :active="page.active">
                                        {{ page.label }}
                                    </PaginationLink>
                                </PaginationItem>
                                
                                <PaginationItem v-if="reservations.next_page_url">
                                    <PaginationNext :href="reservations.next_page_url" />
                                </PaginationItem>
                            </PaginationContent>
                        </Pagination> -->
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>