<script setup>
	import Checkbox from "@/Components/Checkbox.vue";
	import GuestLayout from "@/Layouts/GuestLayout.vue";
	import InputError from "@/Components/InputError.vue";
	import InputLabel from "@/Components/InputLabel.vue";
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
		login: "",
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

		<div
			v-if="status"
			class="mb-4 font-medium text-sm text-green-600">
			{{ status }}
		</div>

		<form @submit.prevent="submit">
			<div>
				<InputLabel
					for="email"
					value="Email or Username" />

				<TextInput
					id="email"
					v-model="form.login"
					autocomplete="username"
					autofocus
					class="mt-1 block w-full"
					required
					type="text" />

				<InputError
					:message="form.errors.login"
					class="mt-2" />
			</div>

			<div class="mt-4">
				<div class="flex justify-between">
					<InputLabel
						for="password"
						value="Password" />
					<Link
						v-if="canResetPassword"
						:href="route('password.request')"
						class="hover:underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md">
						Forgot your password?
					</Link>
				</div>

				<TextInput
					id="password"
					v-model="form.password"
					autocomplete="current-password"
					class="mt-1 block w-full"
					required
					type="password" />

				<InputError
					:message="form.errors.password"
					class="mt-2" />
			</div>

			<div class="mt-4 flex items-center justify-between flex-wrap">
				<label class="flex items-center w-fit cursor-pointer">
					<Checkbox
						v-model:checked="form.remember"
						class="cursor-pointer"
						name="remember" />
					<span
						class="ms-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer"
						>Remember me</span
					>
				</label>
				<p class="text-gray-50">
					Don't have an account?
					<Link
						:href="route('register')"
						class="text-sky-600 hover:underline mt-4"
						v-text="'Register'" />
				</p>
			</div>

			<button
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
				class="w-full bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 my-2 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out">
				Login
			</button>
		</form>
	</GuestLayout>
</template>
