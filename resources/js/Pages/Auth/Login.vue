<template>
	<div class="flex flex-col items-center justify-center h-screen text-white">
		<div
			class="w-full max-w-md bg-black text-white rounded-lg shadow-md p-6 border">
			<h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
				Login
			</h2>
			<form class="flex flex-col space-y-5" @submit.prevent="login">
				<div class="space-y-1 text-sm">
					<label for="email" class="block">Email</label>
					<input
						v-model="form.email"
						@keydown="noSpaces"
						type="email"
						name="email"
						id="email"
						class="w-full px-4 py-3 border-gray-300 transition ease-in-out duration-150 bg-gray-50 text-gray-900 border-0 rounded-md p-2 mb-4"
						placeholder="Email address"
						required />
					<ErrorMessage :error="errors.email" />
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
					<ErrorMessage :error="errors.password" />
				</div>

				<div class="flex items-center justify-between flex-wrap">
					<Link
						href="#"
						class="text-sm text-blue-500 hover:underline"
						v-text="'Forgot password?'" />
					<p class="text-gray-50">
						Don't have an account?
						<Link
							href="/register"
							class="text-sm text-blue-500 hover:underline mt-4"
							v-text="'Register'" />
					</p>
				</div>
				<button
					type="submit"
					class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out">
					Login
				</button>
			</form>
		</div>
	</div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import ErrorMessage from "@/Pages/Shared/ErrorMessage.vue";

defineProps({ errors: Object });

const form = useForm({
	email: "",
	password: "",
});

const noSpaces = (e) => {
	if (e.key === " ") {
		e.preventDefault();
	}
};

const login = () => {
	form.post("/login");
};
</script>

<style scoped>
*:focus {
	border: none !important;
	outline: none !important;
}
</style>
