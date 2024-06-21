<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <h2 class="text-2xl font-extrabold text-gray-200 mb-4 text-center">
            Login
        </h2>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <div class="flex justify-between">
                    <InputLabel for="password" value="Password" />
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="hover:underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md"
                    >
                        Forgot your password?
                    </Link>
                </div>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex items-center justify-between flex-wrap">
                <label class="flex items-center w-fit cursor-pointer">
                    <Checkbox
                        name="remember"
                        v-model:checked="form.remember"
                        class="cursor-pointer"
                    />
                    <span
                        class="ms-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer"
                        >Remember me</span
                    >
                </label>
                <p class="text-gray-50">
                    Don't have an account?
                    <Link
                        class="text-sky-600 hover:underline mt-4"
                        :href="route('register')"
                        v-text="'Register'"
                    />
                </p>
            </div>

            <button
                class="w-full bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 my-2 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Login
            </button>
        </form>
    </GuestLayout>
</template>
