<template>
  <div class="min-h-screen flex items-center justify-center p-4 bg-gray-700">
    <div class="w-full max-w-4xl rounded-lg shadow-sm overflow-hidden bg-gray-100">
      <div class="p-4">
      <div class="flex items-center justify-center mb-6">
      <h1 class="text-2xl font-bold mr-3 dark:text-black">Floors List</h1>
      <span v-if="floors.length > 0" class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
      {{ floors.length }} Total
      </span>
      <span v-else class="bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-0.5 rounded-full italic">
      No floors added yet
      </span>
      </div>
      
      <div class="flex justify-center items-center mb-4 px-4">
        <button @click="addFloor" class="bg-blue-500 text-white px-4 py-2 rounded-md transition duration-300 hover:bg-blue-700 hover:-translate-y-1 hover:scale-105">
        Add New Floor
        </button>
      </div>
      
      <div v-if="floors.length > 0" class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-500">
        <thead>
          <tr class="text-center">
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Name</th>
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Number</th>
          <!-- If the current logged-in is an ADMIN, show the MANAGER NAME -->
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Created By</th>
          <!-- If the MANAGER is the one created that floor -->
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Actions</th>
          </tr>
        </thead>
        
        <tbody class="bg-white divide-y divide-gray-200 text-center">
          <tr v-for="floor in floors" :key="floor.id" class="hover:bg-blue-200">
          <td class="px-3 py-2 whitespace-nowrap text-gray-900" hidden>{{ floor.id }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ floor.name }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ floor.number }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ floor.creator.name || 'Not Available' }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900 text-center">
          <button @click="editFloor(floor.id)" class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
          <button @click="confirmDelete(floor.id)" class="text-red-600 hover:text-red-800">Delete</button>
        </td>
        </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  </template>
  
  <script setup>
  import { router } from '@inertiajs/vue3'
  import { useToast } from "vue-toastification";
  const toast = useToast();

  defineProps({
    floors: {
    type: Array,
    required: true,
    default: () => []
    }
  })
  function addFloor(){
    router.get('/addFloor');
  }
  function editFloor(id){
    router.get(`/editFloor/${id}`);
  }
  function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this floor?')) {
    router.delete(`/delFloor/${id}`, {
    onSuccess: () => {
      toast.success('Floor deleted successfully!', {
        timeout: 2000,
        position: 'bottom-center',
      })
    },
    onError: (errors) => {
      toast.error('There was an error deleting the floor', {
        timeout: 2000,
        position: 'bottom-center'
      })
    }
  })
  }}
  </script>