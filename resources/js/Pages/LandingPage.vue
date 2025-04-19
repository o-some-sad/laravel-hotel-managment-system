<script setup>
import { Head } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import { ArrowRight, Star, Users, Calendar, Home, CheckCircle2 } from 'lucide-vue-next';

defineProps({
  auth: Object,
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <Head title="Welcome to Our Hotel" />
  
  <div class="min-h-screen flex flex-col">
    <Navbar :auth="auth" />
    
    <main class="flex-grow">
      <!-- Hero Section -->
      <!-- For each section that uses container class -->
      <section class="relative bg-gradient-to-r from-primary/10 to-primary/5 dark:from-primary/20 dark:to-primary/10 overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative py-16 md:py-24 lg:py-32">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
              <Badge class="mb-4" variant="outline">Premium Hotel Management</Badge>
              <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Elevate Your Hotel Management Experience</h1>
              <p class="text-lg md:text-xl mb-8 text-muted-foreground">A comprehensive solution for managing hotels, staff, and client reservations with ease and efficiency.</p>
              <div class="flex flex-wrap gap-4">
                <Button size="lg" :href="route('login')" class="group">
                  Get Started
                  <ArrowRight class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                </Button>
                <Button size="lg" variant="outline" :href="route('register')">Learn More</Button>
              </div>
              <div class="mt-8 flex items-center gap-4">
                <div class="flex -space-x-2">
                  <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User" class="w-8 h-8 rounded-full border-2 border-background" />
                  <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="User" class="w-8 h-8 rounded-full border-2 border-background" />
                  <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="User" class="w-8 h-8 rounded-full border-2 border-background" />
                </div>
                <p class="text-sm text-muted-foreground">Trusted by <span class="font-medium text-foreground">500+</span> hotel managers</p>
              </div>
            </div>
            <div class="relative hidden md:block">
              <div class="absolute -inset-0.5 rounded-xl bg-gradient-to-r from-primary to-primary/50 opacity-30 blur"></div>
              <Card class="relative overflow-hidden border-2">
                <img 
                  src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80" 
                  alt="Hotel Management Dashboard" 
                  class="w-full h-auto rounded-lg object-cover"
                />
              </Card>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section id="services" class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center mb-16">
          <Badge variant="outline" class="mb-4">Features</Badge>
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Comprehensive Hotel Management</h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">Our system provides all the tools you need to efficiently manage your hotel operations.</p>
        </div>
        
        <Tabs defaultValue="rooms" class="w-full">
          <TabsList class="grid w-full grid-cols-3 mb-8">
            <TabsTrigger value="rooms">Room Management</TabsTrigger>
            <TabsTrigger value="reservations">Reservations</TabsTrigger>
            <TabsTrigger value="staff">Staff Management</TabsTrigger>
          </TabsList>
          <TabsContent value="rooms" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
              <div>
                <h3 class="text-2xl font-bold mb-4">Efficient Room Management</h3>
                <p class="text-muted-foreground mb-6">Keep track of all your rooms, their status, and maintenance schedules in one place.</p>
                <ul class="space-y-2">
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Real-time room availability tracking</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Automated pricing management</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Maintenance scheduling and alerts</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Detailed room analytics and reports</span>
                  </li>
                </ul>
                <Button class="mt-6">Learn More</Button>
              </div>
              <Card>
                <CardContent class="p-0">
                  <img 
                    src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80" 
                    alt="Room Management" 
                    class="w-full h-auto rounded-lg"
                  />
                </CardContent>
              </Card>
            </div>
          </TabsContent>
          <TabsContent value="reservations" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
              <Card>
                <CardContent class="p-0">
                  <img 
                    src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80" 
                    alt="Reservation System" 
                    class="w-full h-auto rounded-lg"
                  />
                </CardContent>
              </Card>
              <div>
                <h3 class="text-2xl font-bold mb-4">Streamlined Reservation System</h3>
                <p class="text-muted-foreground mb-6">Handle bookings with ease and provide a seamless experience for your guests.</p>
                <ul class="space-y-2">
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Online booking integration</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Automated confirmation emails</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Guest information management</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Flexible payment processing</span>
                  </li>
                </ul>
                <Button class="mt-6">Learn More</Button>
              </div>
            </div>
          </TabsContent>
          <TabsContent value="staff" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
              <div>
                <h3 class="text-2xl font-bold mb-4">Comprehensive Staff Management</h3>
                <p class="text-muted-foreground mb-6">Manage your team efficiently with role-based access control and performance tracking.</p>
                <ul class="space-y-2">
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Role-based access control</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Staff scheduling and shift management</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Performance tracking and analytics</span>
                  </li>
                  <li class="flex items-center gap-2">
                    <CheckCircle2 class="h-5 w-5 text-primary" />
                    <span>Secure staff communication</span>
                  </li>
                </ul>
                <Button class="mt-6">Learn More</Button>
              </div>
              <Card>
                <CardContent class="p-0">
                  <img 
                    src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80" 
                    alt="Staff Management" 
                    class="w-full h-auto rounded-lg"
                  />
                </CardContent>
              </Card>
            </div>
          </TabsContent>
        </Tabs>
      </section>

      <!-- Testimonials Section -->
      <section id="testimonials" class="bg-muted/50 py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-16">
            <Badge variant="outline" class="mb-4">Testimonials</Badge>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Clients Say</h2>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto">Hear from hotel managers and staff who have transformed their operations with our system.</p>
          </div>
          
          <Carousel class="w-full max-w-4xl mx-auto">
            <CarouselContent>
              <CarouselItem>
                <Card>
                  <CardContent class="pt-6 px-8 pb-8">
                    <div class="flex mb-4">
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                    </div>
                    <p class="italic mb-6 text-lg">"This hotel management system has transformed how we operate. Everything is now streamlined and efficient. Our staff can focus on providing excellent service instead of paperwork."</p>
                    <div class="flex items-center gap-4">
                      <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="John Smith" class="w-12 h-12 rounded-full" />
                      <div>
                        <p class="font-semibold">John Smith</p>
                        <p class="text-sm text-muted-foreground">Hotel Manager, Grand Plaza</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </CarouselItem>
              <CarouselItem>
                <Card>
                  <CardContent class="pt-6 px-8 pb-8">
                    <div class="flex mb-4">
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                    </div>
                    <p class="italic mb-6 text-lg">"The reservation system is intuitive and has significantly reduced booking errors. Our guests are happier, and our revenue has increased by 20% since implementation."</p>
                    <div class="flex items-center gap-4">
                      <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full" />
                      <div>
                        <p class="font-semibold">Sarah Johnson</p>
                        <p class="text-sm text-muted-foreground">Receptionist, Luxury Suites</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </CarouselItem>
              <CarouselItem>
                <Card>
                  <CardContent class="pt-6 px-8 pb-8">
                    <div class="flex mb-4">
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                      <Star class="h-5 w-5 text-yellow-500 fill-yellow-500" />
                    </div>
                    <p class="italic mb-6 text-lg">"As a hotel owner with multiple properties, this system has been a game-changer. I can monitor all locations from one dashboard and make data-driven decisions."</p>
                    <div class="flex items-center gap-4">
                      <img src="https://randomuser.me/api/portraits/men/68.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full" />
                      <div>
                        <p class="font-semibold">Michael Chen</p>
                        <p class="text-sm text-muted-foreground">Owner, Horizon Hotels Group</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </CarouselItem>
            </CarouselContent>
            <CarouselPrevious />
            <CarouselNext />
          </Carousel>
        </div>
      </section>

      <!-- Stats Section -->
      <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card>
            <CardContent class="flex flex-col items-center text-center p-6">
              <Users class="h-12 w-12 text-primary mb-4" />
              <h3 class="text-3xl font-bold mb-2">500+</h3>
              <p class="text-muted-foreground">Hotels Using Our System</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent class="flex flex-col items-center text-center p-6">
              <Calendar class="h-12 w-12 text-primary mb-4" />
              <h3 class="text-3xl font-bold mb-2">1M+</h3>
              <p class="text-muted-foreground">Reservations Processed</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent class="flex flex-col items-center text-center p-6">
              <Home class="h-12 w-12 text-primary mb-4" />
              <h3 class="text-3xl font-bold mb-2">30+</h3>
              <p class="text-muted-foreground">Countries Worldwide</p>
            </CardContent>
          </Card>
        </div>
      </section>

      <!-- Contact Section -->
      <section id="contact" class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center mb-16">
          <Badge variant="outline" class="mb-4">Contact Us</Badge>
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Get in Touch</h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">Have questions about our hotel management system? We're here to help.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
          <Card>
            <CardHeader>
              <CardTitle>Send Us a Message</CardTitle>
              <CardDescription>Fill out the form below and we'll get back to you as soon as possible.</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-2">
                    <label class="text-sm font-medium">Name</label>
                    <Input type="text" placeholder="Your name" />
                  </div>
                  <div class="space-y-2">
                    <label class="text-sm font-medium">Email</label>
                    <Input type="email" placeholder="Your email" />
                  </div>
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-medium">Subject</label>
                  <Input type="text" placeholder="How can we help?" />
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-medium">Message</label>
                  <Textarea rows="4" placeholder="Your message" />
                </div>
              </div>
            </CardContent>
            <CardFooter>
              <Button class="w-full">Send Message</Button>
            </CardFooter>
          </Card>
          
          <div class="flex flex-col justify-center">
            <div class="space-y-6">
              <div>
                <h3 class="text-xl font-semibold mb-2">Our Office</h3>
                <p class="text-muted-foreground">123 Hotel Street, Business District<br />New York, NY 10001</p>
              </div>
              <div>
                <h3 class="text-xl font-semibold mb-2">Contact Information</h3>
                <p class="text-muted-foreground mb-1">Email: info@hotelmanagement.com</p>
                <p class="text-muted-foreground mb-1">Phone: +1 (123) 456-7890</p>
                <p class="text-muted-foreground">Support: 24/7 Available</p>
              </div>
              <div>
                <h3 class="text-xl font-semibold mb-2">Business Hours</h3>
                <p class="text-muted-foreground mb-1">Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p class="text-muted-foreground">Saturday - Sunday: Closed</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-primary/5 dark:bg-primary/10 py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Transform Your Hotel Management?</h2>
            <p class="text-lg text-muted-foreground mb-8 max-w-2xl mx-auto">Join hundreds of hotels worldwide that have streamlined their operations and improved guest satisfaction.</p>
            <div class="flex flex-wrap justify-center gap-4">
              <Button size="lg" :href="route('register')">Get Started Today</Button>
              <Button size="lg" variant="outline" href="#contact">Contact Sales</Button>
            </div>
          </div>
        </div>
      </section>
    </main>
    
    <Footer />
  </div>
</template>
