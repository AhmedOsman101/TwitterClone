<template>
    <!-- <Layout> -->
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Register</h2>
            <form class="flex flex-col" @submit.prevent="register">
                <input
                    v-model="form.full_name"
                    type="text"
                    class="bg-gray-100 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                    placeholder="Full Name"
                />
                <input
                    v-model="form.username"
                    type="text"
                    class="bg-gray-100 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                    placeholder="Username"
                />
                <input
                    v-model="form.email"
                    type="email"
                    class="bg-gray-100 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                    placeholder="Email address"
                />
                <input
                    v-model="form.password"
                    type="password"
                    class="bg-gray-100 text-gray-900 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                    placeholder="Password"
                />
                <div class="flex items-center justify-between flex-wrap">
                    <p class="text-gray-900">
                        Already have an account?
                        <Link
                            href="/login"
                            class="text-sm text-blue-500 -200 hover:underline mt-4"
                            >Login</Link
                        >
                    </p>
                </div>
                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-700 to-blue-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-blue-400 hover:to-blue-700 transition-all delay-1000 ease-in-out"
                >
                    Register
                </button>
            </form>
        </div>
    </div>
    <!-- </Layout> -->
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const form = reactive({
    full_name: "",
    username: "",
    email: "",
    password: "",
});

const register = (event) => {
    router.post("/register", form);
};
</script>
