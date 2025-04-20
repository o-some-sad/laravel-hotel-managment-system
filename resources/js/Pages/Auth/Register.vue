<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

defineProps({
    auth: Object,
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

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
                    <CardDescription class="text-center">Sign up to get started with our hotel management system</CardDescription>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4" >
                        <div class="space-y-2">
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                :class="{ 'border-destructive': form.errors.name }"
                            />
                            <p v-if="form.errors.name" class="text-sm text-destructive mt-1">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                :class="{ 'border-destructive': form.errors.email }"
                            />
                            <p v-if="form.errors.email" class="text-sm text-destructive mt-1">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                :class="{ 'border-destructive': form.errors.password }"
                            />
                            <p v-if="form.errors.password" class="text-sm text-destructive mt-1">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="password_confirmation">Confirm Password</Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                :class="{ 'border-destructive': form.errors.password_confirmation }"
                            />
                            <p v-if="form.errors.password_confirmation" class="text-sm text-destructive mt-1">
                                {{ form.errors.password_confirmation }}
                            </p>
                        </div>

                        <Button type="submit" class="w-full" :disabled="form.processing">
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
