<script setup>
import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Alert, AlertDescription } from "@/components/ui/alert";

const props = defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
  mobile: user.mobile || '',
  country: user.country || '',
  gender: user.gender || '',
});
</script>

<template>
  <section>
    <Card>
      <CardHeader>
        <CardTitle>Profile Information</CardTitle>
        <CardDescription>
          Update your account's profile information and email address.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6">
          <div>
            <Label for="name">Name</Label>
            <Input
              id="name"
              type="text"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
              class="mt-1 block w-full"
            />
          </div>

          <div>
            <Label for="email">Email</Label>
            <Input
              id="email"
              type="email"
              v-model="form.email"
              required
              autocomplete="username"
              class="mt-1 block w-full"
            />
          </div>
          
          <div>
            <Label for="mobile">Mobile</Label>
            <Input
              id="mobile"
              type="text"
              v-model="form.mobile"
              autocomplete="tel"
              class="mt-1 block w-full"
            />
          </div>
          
          <div>
            <Label for="country">Country</Label>
            <Input
              id="country"
              type="text"
              v-model="form.country"
              class="mt-1 block w-full"
            />
          </div>
          
          <div>
            <Label for="gender">Gender</Label>
            <select
              id="gender"
              v-model="form.gender"
              class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
            >
              <option value="">Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>

          <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
            <p class="text-sm mt-2 text-muted-foreground">
              Your email address is unverified.
              <Link
                :href="route('verification.send')"
                method="post"
                as="button"
                class="text-primary hover:underline"
              >
                Click here to re-send the verification email.
              </Link>
            </p>

            <div v-show="props.status === 'verification-link-sent'" class="mt-2">
              <Alert>
                <AlertDescription>
                  A new verification link has been sent to your email address.
                </AlertDescription>
              </Alert>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <Button :disabled="form.processing">Save</Button>

            <p v-if="form.recentlySuccessful" class="text-sm text-muted-foreground">Saved.</p>
          </div>
        </form>
      </CardContent>
    </Card>
  </section>
</template>
