<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div>
        <Head title="Log in" />

      <div class="min-h-screen bg-no-repeat bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486520299386-6d106b22014b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80')">
          <div class="flex justify-center items-center md:justify-end relative">
              <div class="absolute top-12 right-10">
                  <BreezeValidationErrors class="mb-4" />

                  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                      {{ status }}
                  </div>
              </div>
              <div class="md:bg-white min-h-screen md:w-1/2 flex justify-center items-center ">
                  <div class="w-[28rem] p-4 md:w-[24rem] flex justify-center items-center">
                      <form @submit.prevent="submit" class="w-full bg-white rounded-md p-4 md:p-0">
                          <div>
                              <span class="text-sm text-gray-900">Bienvenue!</span>
                              <h1 class="text-2xl font-bold">Connectez-vous à votre compte</h1>
                          </div>

                          <div class="mt-5">
                              <BreezeLabel for="email" value="Email" />
                              <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                          </div>

                          <div class="my-4">
                              <BreezeLabel for="password" value="Password" />
                              <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                          </div>

                          <div class="flex justify-between">
                              <div class="block ">
                                  <label class="flex items-center">
                                      <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                                      <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                  </label>
                              </div>
                              <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-blue-700 cursor-pointer hover:underline cursor-pointer">
                                  Forgot your password?
                              </Link>
                          </div>

                          <div class="flex items-center justify-end mt-4">
                              <BreezeButton class="w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                  Se connecter
                              </BreezeButton>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>
</template>
