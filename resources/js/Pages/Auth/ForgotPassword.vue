<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Alert, AlertDescription } from "@/components/ui/alert";
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Mail } from 'lucide-vue-next';

defineProps({
    status: {
        type: String,
    },
    auth: Object,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />
    
    <div class="min-h-screen flex flex-col bg-background">
        <Navbar :auth="auth" />
        
        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <Card class="w-full max-w-md">
                <CardHeader>
                    <CardTitle class="text-2xl font-bold text-center">Forgot Password</CardTitle>
                    <CardDescription class="text-center">
                        Enter your email address and we'll send you a password reset link.
                    </CardDescription>
                </CardHeader>
                
                <CardContent>
                    <Alert v-if="status" class="mb-6 bg-primary/10 border-primary/20">
                        <AlertDescription>{{ status }}</AlertDescription>
                    </Alert>
                    
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
                        
                        <Button type="submit" class="w-full" :disabled="form.processing">
                            <Mail class="mr-2 h-4 w-4" />
                            {{ form.processing ? 'Sending...' : 'Send Reset Link' }}
                        </Button>
                    </form>
                </CardContent>
                
                <CardFooter>
                    <p class="text-center text-sm text-muted-foreground">
                        Remember your password?
                        <Link :href="route('login')" class="text-primary hover:underline font-medium">
                            Back to login
                        </Link>
                    </p>
                </CardFooter>
            </Card>
        </main>
        
        <Footer />
    </div>
</template>
