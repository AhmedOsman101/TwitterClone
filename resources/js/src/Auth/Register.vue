<!--suppress ALL -->

<template>
	<div class="flex flex-col items-center justify-center h-screen text-white">
		<div
			class="w-full max-w-lg bg-black text-white rounded-lg shadow-md p-6 border scale-95">
			<h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
				Register
			</h2>
			<form
				class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3"
				novalidate
				@submit.prevent="register">
				<div class="space-y-1 text-sm col-span-3">
					<label class="block" for="full_name">Full Name</label>
					<input
						id="full_name"
						v-model="form.full_name"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						name="full_name"
						placeholder="Full Name"
						required
						type="text" />
					<ErrorMessage :error="errors.full_name" />
				</div>
				<div class="space-y-1 text-sm col-span-3">
					<label class="block" for="username">Username</label>
					<input
						id="username"
						v-model="form.username"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						name="username"
						placeholder="Username"
						required
						type="text"
						@keydown="noSpaces" />
					<ErrorMessage :error="errors.username" />
				</div>
				<div class="space-y-1 text-sm col-span-full">
					<label class="block" for="email">Email</label>
					<input
						id="email"
						v-model="form.email"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						name="email"
						placeholder="Email address"
						required
						type="email"
						@keydown="noSpaces" />
					<ErrorMessage :error="errors.email" />
				</div>

				<div class="space-y-1 text-sm col-span-3">
					<label class="block" for="password">Password</label>
					<input
						id="password"
						v-model="form.password"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						name="password"
						placeholder="Password"
						required
						type="password" />
					<ErrorMessage :error="errors.password" />
				</div>

				<div class="space-y-1 text-sm col-span-3">
					<label class="block" for="password_confirmation"
						>Confirm Password</label
					>
					<input
						id="password"
						v-model="form.password_confirmation"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						name="password"
						placeholder="Confirm Password"
						required
						type="password" />
				</div>

				<div
					class="flex items-center justify-between flex-wrap col-span-full">
					<p class="text-gray-50">
						Already have an account?
						<Link
							class="text-sm text-blue-500 hover:underline mt-4"
							href="/login"
							v-text="'Login'" />
					</p>
				</div>
				<button
					class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out col-span-full"
					type="submit">
					Register
				</button>
			</form>
		</div>
	</div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import ErrorMessage from "@/src/Components/ErrorMessage.vue";

defineProps({ errors: Object });

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
