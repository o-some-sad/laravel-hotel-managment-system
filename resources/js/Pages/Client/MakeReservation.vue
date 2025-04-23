<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import { useTheme } from "@/composables/useTheme";
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const { theme } = useTheme();
const { room } = usePage().props;

const form = useForm({
    accompany_number: 1,
});

const submit = () => {
    if (form.accompany_number > room.capacity) {
        toast.error(`Accompany number cannot exceed room capacity (${room.capacity}).`);
        return;
    }

    form.post(route('reservations.store', room.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Reservation created successfully! Proceeding to payment...');
            router.visit(route('client.reservations.index'));
        },
        onError: () => {
            toast.error('Something went wrong! Please try again.');
        },
    });
};
</script>

<template>
    <div class="p-8" :class="theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-black'">

        <Head title="Make Reservation" />
        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Reserve Room #{{ room.number }}</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-2 font-semibold">Room Capacity</label>
                    <p>{{ room.capacity }} persons</p>
                </div>

                <div>
                    <label for="accompany_number" class="block mb-2 font-semibold">Number of Accompany</label>
                    <input type="number" id="accompany_number" v-model="form.accompany_number" min="1"
                        :max="room.capacity" required
                        class="w-full rounded border p-2 focus:outline-none dark:bg-gray-700 dark:border-gray-600" />
                    <span v-if="form.errors.accompany_number" class="text-sm text-red-500">{{
                        form.errors.accompany_number }}</span>
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                    :disabled="form.processing">
                    {{ form.processing ? 'Processing...' : 'Proceed to Pay' }}
                </button>
            </form>

            <div class="mt-6 text-center">
                <Link :href="route('reservations.index')" class="text-primary underline">
                Back to Available Rooms
                </Link>
            </div>
        </div>
    </div>
</template>
