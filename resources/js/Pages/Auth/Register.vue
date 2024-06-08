<!--suppress ALL -->

<template>
  <div class="flex flex-col items-center justify-center h-screen text-white">
    <div
        class="w-full max-w-lg bg-black text-white rounded-lg shadow-md p-6 border scale-95">
      <h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
        Register
      </h2>
      <form class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3" @submit.prevent="register">
        <div class="space-y-1 text-sm col-span-3">
          <label for="full_name" class="block">Full Name</label>
          <input
              v-model="form.full_name"
              type="text"
              name="full_name"
              id="full_name"
              class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
              placeholder="Full Name"
              required/>
          <ErrorMessage :error="errors.full_name"/>
        </div>
        <div class="space-y-1 text-sm col-span-3">
          <label for="username" class="block">Username</label>
          <input
              v-model="form.username"
              @keydown="noSpaces"
              type="text"
              name="username"
              id="username"
              class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
              placeholder="Username"
              required/>
          <ErrorMessage :error="errors.username"/>

        </div>
        <div class="space-y-1 text-sm col-span-full">
          <label for="email" class="block">Email</label>
          <input
              v-model="form.email"
              @keydown="noSpaces"
              type="email"
              name="email"
              id="email"
              class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
              placeholder="Email address"
              required/>
          <ErrorMessage :error="errors.email"/>

        </div>

        <div class="space-y-1 text-sm col-span-3">
          <label for="password" class="block">Password</label>
          <input
              v-model="form.password"
              type="password"
              name="password"
              id="password"
              class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
              placeholder="Password"
              required/>
          <ErrorMessage :error="errors.password"/>

        </div>

        <div class="space-y-1 text-sm col-span-3">
          <label for="password_confirmation" class="block"
          >Confirm Password</label
          >
          <input
              v-model="form.password_confirmation"
              type="password"
              placeholder="Confirm Password"
              name="password"
              id="password"
              class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
              required/>
        </div>

        <div class="flex items-center justify-between flex-wrap col-span-full">
          <p class="text-gray-50">
            Already have an account?
            <Link
                href="/login"
                class="text-sm text-blue-500 hover:underline mt-4" v-text="'Login'"
            />
          </p>
        </div>
        <button
            type="submit"
            class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out col-span-full">
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import ErrorMessage from "@/Pages/Shared/ErrorMessage.vue";

defineProps({errors: Object});

const form = useForm({
  full_name: "",
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const noSpaces = (e) => {
  if (e.key === " ") {
    e.preventDefault();
  }
};

const register = () => {
  form.post("/register");
};
</script>

<style scoped>
*:focus {
  outline: none !important;
  border: initial;
}
</style>
