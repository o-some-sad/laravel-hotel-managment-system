<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
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
import { Button } from "@/components/ui/button";
// import { 
//   Pagination
//   PaginationContent, 
//   PaginationItem, 
//   PaginationLink, 
//   PaginationNext, 
//   PaginationPrevious 
// } from "@/components/ui/pagination";

const props = defineProps({
    pendingClients: Object
});

const form = useForm({});

const approveClient = (clientId) => {
    form.post(route('receptionist.approve-client', clientId), {
        preserveScroll: true,
        onSuccess: () => {
            // Success notification can be added here
        },
    });
};
</script>

<template>
    <Head title="Pending Clients" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pending Clients
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table>
                            <TableCaption>List of pending clients waiting for approval</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Mobile</TableHead>
                                    <TableHead>Country</TableHead>
                                    <TableHead>Gender</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="client in pendingClients.data" :key="client.id">
                                    <TableCell>{{ client.name }}</TableCell>
                                    <TableCell>{{ client.email }}</TableCell>
                                    <TableCell>{{ client.mobile ? client.mobile : 'N/A' }}</TableCell>
                                    <TableCell>{{ client.country_code ? client.country_code : 'N/A' }}</TableCell>
                                    <TableCell>{{ client.gender ? client.gender : 'N/A' }}</TableCell>
                                    <TableCell>
                                        <Button @click="approveClient(client.id)" variant="outline">
                                            Approve
                                        </Button>
                                    </TableCell>
                                </TableRow>
                                <TableRow v-if="pendingClients.data.length === 0">
                                    <TableCell colspan="6" class="text-center">No pending clients found</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        
                     <!--   
                        <Pagination v-if="pendingClients.data.length > 0" class="mt-4">
                            <PaginationContent>
                                <PaginationItem v-if="pendingClients.prev_page_url">
                                    <PaginationPrevious :href="pendingClients.prev_page_url" />
                                </PaginationItem>
                                
                                <PaginationItem v-for="page in pendingClients.links.slice(1, -1)" :key="page.label">
                                    <PaginationLink :href="page.url" :active="page.active">
                                        {{ page.label }}
                                    </PaginationLink>
                                </PaginationItem>
                                
                                <PaginationItem v-if="pendingClients.next_page_url">
                                    <PaginationNext :href="pendingClients.next_page_url" />
                                </PaginationItem>
                            </PaginationContent>
                        </Pagination>
                    -->
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>