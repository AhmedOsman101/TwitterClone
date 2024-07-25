<script setup lang="ts">
	import GuestLayout from "@/Layouts/GuestLayout.vue";
	import InputError from "@/Components/InputError.vue";
	import InputLabel from "@/Components/InputLabel.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import TextInput from "@/Components/TextInput.vue";
	import { Head, Link, useForm } from "@inertiajs/vue3";

	const form = useForm({
		full_name: "",
		username: "",
		email: "",
		password: "",
		password_confirmation: "",
	});

	const noSpaces = (e: KeyboardEvent) => {
		if (e.key === " ") e.preventDefault();
	};

	const submit = () => {
		form.post(route("register"), {
			onFinish: () => form.reset("password", "password_confirmation"),
		});
	};
</script>

<template>
	<GuestLayout>
		<Head title="Register" />

		<h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
			Register
		</h2>

		<form
			@submit.prevent="submit"
			class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3 pb-2"
			novalidate>
			<div class="space-y-1 text-sm col-span-3">
				<InputLabel
					for="full_name"
					value="Full Name" />

				<TextInput
					id="full_name"
					type="text"
					class="mt-1 block w-full"
					v-model="form.full_name"
					placeholder="Full Name"
					required
					autofocus
					autocomplete="full_name" />

				<InputError
					class="mt-2"
					:message="form.errors.full_name" />
			</div>

			<div class="space-y-1 text-sm col-span-3">
				<InputLabel
					for="username"
					value="Username" />

				<TextInput
					id="username"
					type="text"
					class="mt-1 block w-full"
					v-model="form.username"
					placeholder="Username"
					required
					autofocus
					autocomplete="username"
					@keydown="noSpaces" />

				<InputError
					class="mt-2"
					:message="form.errors.username" />
			</div>

			<div class="space-y-1 text-sm col-span-full">
				<InputLabel
					for="email"
					value="Email" />

				<TextInput
					id="email"
					type="email"
					class="mt-1 block w-full"
					v-model="form.email"
					placeholder="Email address"
					required
					autocomplete="username"
					@keydown="noSpaces" />

				<InputError
					class="mt-2"
					:message="form.errors.email" />
			</div>

			<div class="space-y-1 text-sm col-span-3">
				<InputLabel
					for="password"
					value="Password" />

				<TextInput
					id="password"
					type="password"
					class="mt-1 block w-full"
					v-model="form.password"
					placeholder="Password"
					required
					autocomplete="new-password" />

				<InputError
					class="mt-2 w-[150%]"
					:message="form.errors.password" />
			</div>

			<div class="space-y-1 text-sm col-span-3">
				<InputLabel
					for="password_confirmation"
					value="Confirm Password" />

				<TextInput
					id="password_confirmation"
					type="password"
					class="mt-1 block w-full"
					v-model="form.password_confirmation"
					placeholder="Confirm Password"
					required
					autocomplete="new-password" />

				<InputError
					class="mt-2"
					:message="form.errors.password_confirmation" />
			</div>
			<div
				class="flex items-center justify-between flex-wrap col-span-full">
				<p class="text-gray-50">
					Already have an account?
					<Link
						class="text-blue-500 hover:underline mt-4"
						:href="route('login')"
						v-text="'Login'" />
				</p>
			</div>
			<button
				class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out col-span-full"
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing">
				Register
			</button>
		</form>
	</GuestLayout>
</template>
