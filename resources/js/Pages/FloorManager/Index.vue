<template>
  <div class="min-h-screen flex items-center justify-center p-4 bg-gray-700">
    <div class="w-full max-w-4xl rounded-lg shadow-sm overflow-hidden">
      <div class="min-h-screen p-4 bg-gray-100">
    <div class="flex items-center justify-center mb-6">
      <h1 class="text-2xl font-bold mr-3 dark: text-black">Floors List</h1>
      <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
        {{ floors.length }} Total
      </span>
    </div>
    <table class="min-w-full divide-y divide-gray-500">
      <thead>
        <tr class="text-center">
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Name</th>
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Number</th>
          <!-- *********************************************************** -->
          <!-- If the current logged-in is an ADMIN, show MANAGER-NAME  -->
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Created By</th>
          <!-- *********************************************************** -->
          <!-- If the MANAGER is the one who created this floor -->
          <th class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap bg-gray-50">Actions</th>
        </tr>
      </thead>
      
      <tbody class="bg-white divide-y divide-gray-200 text-center">
        <tr v-for="floor in floors" :key="floor.id" class="hover:bg-blue-200">
          <td class="px-3 py-2 whitespace-nowrap text-gray-900" hidden>{{ floor.id }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ floor.name }}</td>
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ floor.number }}</td>
          <!-- *********************************************************** -->
          <!-- If the current logged-in is an ADMIN, show MANAGER-NAME  -->
          <td class="px-3 py-2 whitespace-nowrap text-gray-900">
            {{ floor.creator.name || 'Not Available' }}
          </td>

          <!-- *********************************************************** -->
          <!-- If the MANAGER is the one who created this floor -->
          <td class="px-3 py-2 whitespace-nowrap text-gray-900 text-center">
            <button @click="editFloor(floor.id)" class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
            <button class="text-red-600 hover:text-red-800">Delete</button>
          </td>
        </tr>
      </tbody>
    </table><br>
    <div>
    <button @click="addFloor" class="bg-blue-400 float-end rounded-md w-[150px] transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-blue-600 hover:text-white ...">
  Add new floor
</button>
</div>
  </div>
  </div>
</div>
</template>
<script setup>
import { router } from '@inertiajs/vue3'
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
</script>