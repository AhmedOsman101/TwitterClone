<template>
	<div class="flex flex-col items-center justify-center h-screen text-white">
		<div
			class="w-full max-w-md bg-black text-white rounded-lg shadow-md p-6 border scale-95">
			<h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
				Register
			</h2>
			<form class="flex flex-col space-y-5" @submit.prevent="register">
				<div class="space-y-1 text-sm">
					<label for="full_name" class="block">Full Name</label>
					<input
						v-model="form.full_name"
						type="text"
						name="full_name"
						id="full_name"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						placeholder="Full Name"
						required />
				</div>
				<div class="space-y-1 text-sm">
					<label for="username" class="block">Username</label>
					<input
						v-model="form.username"
						@keypress="noSpaces"
						type="text"
						name="username"
						id="username"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						placeholder="Username"
						required />
				</div>
				<div class="space-y-1 text-sm">
					<label for="email" class="block">Email</label>
					<input
						v-model="form.email"
						@keypress="noSpaces"
						type="email"
						name="email"
						id="email"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						placeholder="Email address"
						required />
				</div>

				<div class="space-y-1 text-sm">
					<label for="password" class="block">Password</label>
					<input
						v-model="form.password"
						type="password"
						name="password"
						id="password"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						placeholder="Password"
						required />
				</div>

				<div class="space-y-1 text-sm">
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
						required />
				</div>

				<div class="flex items-center justify-between flex-wrap">
					<p class="text-gray-50">
						Already have an account?
						<Link
							href="/login"
							class="text-sm text-blue-500 hover:underline mt-4"
							>Login</Link
						>
					</p>
				</div>
				<button
					type="submit"
					class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out">
					Register
				</button>
			</form>
		</div>
	</div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

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