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
    approvedClients: Object
});
</script>

<template>
    <Head title="My Approved Clients" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Approved Clients
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table>
                            <TableCaption>Clients you have approved</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Mobile</TableHead>
                                    <TableHead>Country</TableHead>
                                    <TableHead>Gender</TableHead>
                                    <TableHead>Approval Date</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="client in approvedClients.data" :key="client.id">
                                    <TableCell>{{ client.name }}</TableCell>
                                    <TableCell>{{ client.email }}</TableCell>
                                    <TableCell>{{ client.mobile ? client.mobile : 'N/A' }}</TableCell>
                                    <TableCell>{{ client.country_code ? client.country_code : 'N/A' }}</TableCell>
                                    <TableCell>{{ client.gender ? client.gender : 'N/A' }}</TableCell>
                                    <TableCell>{{ new Date(client.approved_at).toLocaleDateString() }}</TableCell>
                                </TableRow>
                                <TableRow v-if="approvedClients.data.length === 0">
                                    <TableCell colspan="6" class="text-center">No approved clients found</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        
                        <!-- <Pagination v-if="approvedClients.data.length > 0" class="mt-4">
                            <PaginationContent>
                                <PaginationItem v-if="approvedClients.prev_page_url">
                                    <PaginationPrevious :href="approvedClients.prev_page_url" />
                                </PaginationItem>
                                
                                <PaginationItem v-for="page in approvedClients.links.slice(1, -1)" :key="page.label">
                                    <PaginationLink :href="page.url" :active="page.active">
                                        {{ page.label }}
                                    </PaginationLink>
                                </PaginationItem>
                                
                                <PaginationItem v-if="approvedClients.next_page_url">
                                    <PaginationNext :href="approvedClients.next_page_url" />
                                </PaginationItem>
                            </PaginationContent>
                        </Pagination> -->
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>