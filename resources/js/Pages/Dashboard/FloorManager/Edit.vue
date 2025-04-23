<template> 
    <div class="my-6 flex justify-center items-center min-h-screen">
                <div class="grid sm:grid-cols-2 items-center gap-16 transition delay-50 duration-100 ease-in-out hover:-translate-y-1 hover:scale-110 p-8 mx-auto max-w-4xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md text-[#333] font-[sans-serif]">
                    <div class="m-auto">
                        <h1 class="text-3xl font-extrabold">Edit Floor</h1>
                        <p class="text-sm text-gray-400 mt-3">Need to make some changes? Update your floor details to keep everything accurate and up to date. Whether you're refining your setup or correcting a small detail, this is the place to do it. Let’s keep things running smoothly—one floor at a time.</p>
                        <div class="mt-12">
                        </div>
                    </div>
                    <form @submit.prevent="submitForm" class="ml-auo space-y-4" method="POST">
                        <input type='text' placeholder='Name' name='name' v-model="form.name"
                            class="w-full rounded-md px-4 border text-sm outline-[#007bff]" />
                        <p class="text-red-700 font-bold" v-if="$page.props.errors.name">{{ $page.props.errors.name }}</p>
                            <div class="flex items-center justify-center">
                            <button
                            class="text-center w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200">
                            Update</button>
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
    const props = defineProps({
    floor: {
        type: Object,
        required: true
    }
    })
    const form = reactive({
        id: props.floor.id,
        name: props.floor.name
    })
    function submitForm() {
        router.put(`/dashboard/updateFloor/${form.id}`, form, {
    onSuccess: () => {
      form.name = ''
      toast.success('Floor edited successfully!', {
        timeout: 2000,
        position: 'bottom-center',
      })
    },
    onError: (errors) => {
      toast.error('There was an error editing the floor', {
        timeout: 2000,
        position: 'bottom-center'
      })
    }
  })
    }
    </script>