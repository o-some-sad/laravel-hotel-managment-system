<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import Swal from 'sweetalert2';


defineProps({
    auth: Object,
    countries: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    country: '',
    gender: '',
    avatar_image: null,
});
const handleAvatarUpload = (event) => {
    form.avatar_image = event.target.files[0];
};

const submit = () => {
    form.post(route('register'),{
        forceFormData: true,
        onSuccess: () => {
            form.reset('password', 'password_confirmation');

            Swal.fire({
                icon: 'success',
                title: 'Registration Successful!',
                text: 'Your account is pending approval. We will send you an email once approved!',
                confirmButtonText: 'OK'
            }).then(() => {
                router.visit('/');
            });
        },
    });
};
</script>

<template>

    <div class="min-h-screen flex flex-col bg-background">

        <Head title="Register" />
        <Navbar :auth="auth" />

        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <Card class="w-full max-w-md">
                <CardHeader>
                    <CardTitle class="text-2xl font-bold text-center">Create an Account</CardTitle>
                    <CardDescription class="text-center">Sign up to get started with our hotel management system
                    </CardDescription>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Name <span class="text-destructive">*</span></Label>
                            <Input id="name" type="text" v-model="form.name"  autofocus autocomplete="name"
                                :class="{ 'border-destructive': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-sm text-destructive mt-1">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email <span class="text-destructive">*</span></Label>
                            <Input id="email" type="email" v-model="form.email" autocomplete="username"
                                :class="{ 'border-destructive': form.errors.email }" />
                            <p v-if="form.errors.email" class="text-sm text-destructive mt-1">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="password">Password <span class="text-destructive">*</span></Label>
                            <Input id="password" type="password" v-model="form.password"
                                autocomplete="new-password" :class="{ 'border-destructive': form.errors.password }" />
                            <p v-if="form.errors.password" class="text-sm text-destructive mt-1">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="password_confirmation">Confirm Password <span
                                    class="text-destructive">*</span></Label>
                            <Input id="password_confirmation" type="password" v-model="form.password_confirmation"
                             autocomplete="new-password"
                                :class="{ 'border-destructive': form.errors.password_confirmation }" />
                            <p v-if="form.errors.password_confirmation" class="text-sm text-destructive mt-1">
                                {{ form.errors.password_confirmation }}
                            </p>
                        </div>
                        <!-- Country Dropdown -->
                        <div class="space-y-2">
                            <Label for="country">Country <span class="text-destructive">*</span></Label>
                            <select id="country" v-model="form.country" class="w-full rounded px-3 py-2 border focus:outline-none focus:ring-2 focus:ring-primary
           bg-white text-black dark:bg-gray-800 dark:text-white dark:border-gray-600"
                                :class="{ 'border-destructive': form.errors.country }">
                                <option value="" disabled>Select a country</option>
                                <option v-for="country in countries" :key="country.id" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <p v-if="form.errors.country" class="text-sm text-destructive mt-1">
                                {{ form.errors.country }}
                            </p>
                        </div>

                        <!-- Gender Dropdown -->
                        <div class="space-y-2">
                            <Label for="gender">Gender <span class="text-destructive">*</span></Label>
                            <select id="gender" v-model="form.gender"
                            class="w-full rounded px-3 py-2 border focus:outline-none focus:ring-2 focus:ring-primary
                            bg-white text-black dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            :class="{ 'border-destructive': form.errors.gender }">
                                <option value="" disabled>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <p v-if="form.errors.gender" class="text-sm text-destructive mt-1">
                                {{ form.errors.gender }}
                            </p>
                        </div>

                        <!-- Avatar Upload -->
                        <div class="space-y-2">
                            <Label for="avatar_image">Avatar <span
                            class="text-muted-foreground" >(optional)</span></Label>

                            <Input id="avatar_image" type="file" @change="handleAvatarUpload" accept="image/jpeg,image/jpg" />
                            <p v-if="form.errors.avatar_image" class="text-sm text-destructive mt-1">
                                {{ form.errors.avatar_image }}
                            </p>
                        </div>

                        <Button type="submit" class="w-full py-2 px-4 bg-primary text-white font-semibold rounded hover:bg-primary-dark transition
                        dark:bg-blue-600 dark:hover:bg-blue-700" :disabled="form.processing">
                            {{ form.processing ? 'Creating account...' : 'Create account' }}
                        </Button>
                    </form>
                </CardContent>

                <CardFooter>
                    <p class="text-center text-sm text-muted-foreground">
                        Already have an account?
                        <Link :href="route('login')" class="text-primary hover:underline font-medium">
                        Sign in
                        </Link>
                    </p>
                </CardFooter>
            </Card>
        </main>

        <Footer />
    </div>
</template>
