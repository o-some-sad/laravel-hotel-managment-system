<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { useToast } from "vue-toastification"
import { Button } from "@/components/ui/button"
import DataTable from "./data-table.vue"
import { getColumns } from "./columns"
import { computed, watch, onMounted } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const toast = useToast()

const props = defineProps({
  floors: Array,
  isAdmin: Boolean,
  isManager: Boolean,
  userId: Number
})

function addFloor() {
  router.get('/dashboard/addFloor')
}

function editFloor(id) {
  router.get(`/dashboard/editFloor/${id}`)
}

function confirmDelete(id) {
  if (confirm('Are you sure you want to delete this floor?')) {
    router.delete(`/dashboard/delFloor/${id}`, {
      onSuccess: (page) => {
        const floorStillExists = props.floors.some(floor => floor.id === id);
        if (floorStillExists) {
          toast.error("Can't delete floor as there are rooms assigned to it", {
            timeout: 4000,
            position: 'bottom-center'
          });
        } else {
          toast.success('Floor deleted successfully!', {
            timeout: 2000,
            position: 'bottom-center',
          });
        }
      },
      onError: (errors) => {
        toast.error(errors.error || "Can't delete floor as there are rooms assigned to it", {
          timeout: 4000,
          position: 'bottom-center'
        });
      }
    });
  }
}

const columns = computed(() => getColumns(editFloor, confirmDelete, props.isAdmin, props.isManager, props.userId))
</script>

<template>
  <DashboardLayout>
<div class="min-h-screen p-6 bg-background">
  <div class="container mx-auto space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="flex justify-center items-center gap-6">
        <span class="text-2xl font-bold">Floors Management</span>
        <span v-if="floors.length > 0" class="w-[60px] text-center bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
    {{ floors.length }} Total
    </span>
    <span v-else class="bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-0.5 rounded-full italic">
    No floors added yet
    </span>
  </div>
        <p class="text-muted-foreground">Manage your hotel floors</p>
      </div>
      <Button class="text-white  transition delay-50 duration-100 ease-in-out hover:-translate-y-1 hover:scale-110" @click="addFloor" variant="default">
        Add New Floor
      </Button>
    </div>
    
    <div class="rounded-md border">
      <DataTable :columns="columns" :data="floors" :manualPagination="true"/>
    </div>
  </div>
</div>
</DashboardLayout>
</template>