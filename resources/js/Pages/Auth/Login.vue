<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    auth: Object,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />
    
    <div class="min-h-screen flex flex-col bg-background">
        <Navbar :auth="auth" />
        
        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <Card class="w-full max-w-md">
                <CardHeader>
                    <CardTitle class="text-2xl font-bold text-center">Welcome Back</CardTitle>
                    <CardDescription class="text-center">Sign in to your account to continue</CardDescription>
                </CardHeader>
                
                <CardContent>
                    <div v-if="status" class="mb-4 p-4 bg-primary/10 text-primary rounded-md text-sm">
                        {{ status }}
                    </div>
                    
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input 
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                :class="{ 'border-destructive': form.errors.email }"
                            />
                            <p v-if="form.errors.email" class="text-sm text-destructive mt-1">
                                {{ form.errors.email }}
                            </p>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <Label for="password">Password</Label>
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm text-primary hover:underline"
                                >
                                    Forgot password?
                                </Link>
                            </div>
                            <Input 
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                :class="{ 'border-destructive': form.errors.password }"
                            />
                            <p v-if="form.errors.password" class="text-sm text-destructive mt-1">
                                {{ form.errors.password }}
                            </p>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <Checkbox id="remember" v-model:checked="form.remember" />
                            <label for="remember" class="text-sm text-muted-foreground cursor-pointer">
                                Remember me
                            </label>
                        </div>
                        
                        <Button type="submit" class="w-full" :disabled="form.processing">
                            {{ form.processing ? 'Signing in...' : 'Sign in' }}
                        </Button>
                    </form>
                </CardContent>
                
                <CardFooter>
                    <p class="text-center text-sm text-muted-foreground">
                        Don't have an account?
                        <Link :href="route('register')" class="text-primary hover:underline font-medium">
                            Create an account
                        </Link>
                    </p>
                </CardFooter>
            </Card>
        </main>
        
        <Footer />
    </div>
</template>
