<template> 
<div class="my-6 flex justify-center items-center min-h-screen">
            <div class="grid sm:grid-cols-2 items-center gap-16 transition delay-50 duration-100 ease-in-out hover:-translate-y-1 hover:scale-110 p-8 mx-auto max-w-4xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md text-[#333] font-[sans-serif]">
                <div class="m-auto">
                    <h1 class="text-3xl font-extrabold">Add a New Floor</h1>
                    <p class="text-sm text-gray-400 mt-3">Expanding your hotel ? Add a new floor to keep everything running smoothly. Whether you're upgrading or just getting started, this is where you begin. Let’s build something great—one floor at a time.</p>
                    <div class="mt-12">
                    </div>
                </div>
                <form @submit.prevent="submitForm" class="ml-auo space-y-4" method="POST">
                    <input type='text' placeholder='Name' v-model="form.name"
                        class="w-full rounded-md px-4 border text-sm outline-[#007bff]" />
                    <p class="text-red-700 font-bold" v-if="$page.props.errors.name">{{ $page.props.errors.name }}</p>
                    <!-- <input type='text' placeholder='Subject'
                        class="w-full rounded-md py-2.5 px-4 border text-sm outline-[#007bff]" /> -->
                        <div class="flex items-center justify-center">
                        <button
                        class="text-center w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200">
                        Add</button>
                    </div>
                </form>
            </div>
        </div>
</template>
<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const toast = useToast()
const form = reactive({
  name: ''
})

function submitForm() {
  router.post('/storeFloor', form, {
    onSuccess: () => {
      form.name = ''
      toast.success('Floor added successfully!', {
        timeout: 2000,
        position: 'bottom-center',
      })
    },
    onError: (errors) => {
      toast.error('There was an error adding the floor', {
        timeout: 2000,
        position: 'bottom-center'
      })
    }
  })
}
</script>