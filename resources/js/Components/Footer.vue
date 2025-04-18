<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Facebook, Twitter, Instagram, Linkedin, Mail } from 'lucide-vue-next';
</script>

<template>
  <footer class="border-t bg-background">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12">
        <div>
          <h3 class="text-xl font-bold mb-4">Hotel Management</h3>
          <p class="text-muted-foreground mb-6">Your complete solution for hotel operations, designed to streamline management and enhance guest experiences.</p>
          <div class="flex space-x-4">
            <a href="#" class="text-muted-foreground hover:text-foreground transition-colors">
              <Facebook class="h-5 w-5" />
              <span class="sr-only">Facebook</span>
            </a>
            <a href="#" class="text-muted-foreground hover:text-foreground transition-colors">
              <Twitter class="h-5 w-5" />
              <span class="sr-only">Twitter</span>
            </a>
            <a href="#" class="text-muted-foreground hover:text-foreground transition-colors">
              <Instagram class="h-5 w-5" />
              <span class="sr-only">Instagram</span>
            </a>
            <a href="#" class="text-muted-foreground hover:text-foreground transition-colors">
              <Linkedin class="h-5 w-5" />
              <span class="sr-only">LinkedIn</span>
            </a>
          </div>
        </div>
        
        <div>
          <h4 class="font-bold mb-4">Quick Links</h4>
          <ul class="space-y-2">
            <li><Link href="/" class="text-muted-foreground hover:text-foreground transition-colors">Home</Link></li>
            <li><Link href="#services" class="text-muted-foreground hover:text-foreground transition-colors">Services</Link></li>
            <li><Link href="#testimonials" class="text-muted-foreground hover:text-foreground transition-colors">Testimonials</Link></li>
            <li><Link href="#contact" class="text-muted-foreground hover:text-foreground transition-colors">Contact</Link></li>
            <li><Link href="/about" class="text-muted-foreground hover:text-foreground transition-colors">About Us</Link></li>
          </ul>
        </div>
        
        <div>
          <h4 class="font-bold mb-4">Services</h4>
          <ul class="space-y-2">
            <li><Link href="#" class="text-muted-foreground hover:text-foreground transition-colors">Room Management</Link></li>
            <li><Link href="#" class="text-muted-foreground hover:text-foreground transition-colors">Reservations</Link></li>
            <li><Link href="#" class="text-muted-foreground hover:text-foreground transition-colors">Staff Management</Link></li>
            <li><Link href="#" class="text-muted-foreground hover:text-foreground transition-colors">Client Portal</Link></li>
            <li><Link href="#" class="text-muted-foreground hover:text-foreground transition-colors">Analytics</Link></li>
          </ul>
        </div>
        
        <div>
          <h4 class="font-bold mb-4">Subscribe to Our Newsletter</h4>
          <p class="text-muted-foreground mb-4">Stay updated with our latest features and news.</p>
          <div class="flex space-x-2">
            <Input type="email" placeholder="Your email" />
            <Button variant="default" size="icon">
              <Mail class="h-4 w-4" />
            </Button>
          </div>
          <p class="text-sm text-muted-foreground mt-4">By subscribing, you agree to our Privacy Policy.</p>
        </div>
      </div>
      
      <div class="border-t mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-muted-foreground text-sm mb-4 md:mb-0">&copy; {{ new Date().getFullYear() }} Hotel Management System. All rights reserved.</p>
        <div class="flex space-x-6">
          <Link href="#" class="text-sm text-muted-foreground hover:text-foreground transition-colors">Privacy Policy</Link>
          <Link href="#" class="text-sm text-muted-foreground hover:text-foreground transition-colors">Terms of Service</Link>
          <Link href="#" class="text-sm text-muted-foreground hover:text-foreground transition-colors">Cookie Policy</Link>
        </div>
      </div>
    </div>
  </footer>
</template>