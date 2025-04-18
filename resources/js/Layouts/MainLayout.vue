<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navigation -->
    <header class="bg-white shadow-sm">
      <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
          <div class="flex items-center">
            <Link href="/" class="text-xl font-bold text-slate-900">Hotel Management</Link>
          </div>
          
          <nav class="hidden md:flex space-x-8">
            <Link href="/" class="text-slate-600 hover:text-slate-900">Home</Link>
            <Link href="#" class="text-slate-600 hover:text-slate-900">About</Link>
            <Link href="#" class="text-slate-600 hover:text-slate-900">Services</Link>
            <Link href="#" class="text-slate-600 hover:text-slate-900">Contact</Link>
          </nav>
          
          <div class="flex items-center space-x-4">
            <Link href="/login">
              <Button variant="outline">Login</Button>
            </Link>
            <Link href="/register">
              <Button>Register</Button>
            </Link>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
      <slot></slot>
    </main>
  </div>
</template>