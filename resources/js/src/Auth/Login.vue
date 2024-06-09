<template>
	<div class="flex flex-col items-center justify-center h-screen text-white">
		<div
			class="w-full max-w-md bg-black text-white rounded-lg shadow-md p-6 border">
			<h2 class="text-2xl font-bold text-gray-200 mb-4 text-center">
				Login
			</h2>
			<form class="flex flex-col space-y-5" @submit.prevent="login">
				<div class="space-y-1 text-sm">
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
				<div class="space-y-1 text-sm">
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

				<div class="flex items-center justify-between flex-wrap">
					<!--  ToDo: add remember me functionality-->
					<!-- <Link href="#" class="text-sm text-blue-500 hover:underline" v-text="'Forgot password?'" /> -->

					<div class="flex items-center">
						<input
							id="remember"
							v-model="form.remember"
							aria-label="Remember me"
							class="mr-2 rounded-sm focus:ring-blue-600 focus:border-blue-600 focus:ring-2 accent-blue-600"
							name="remember"
							type="checkbox" />
						<label class="text-sm" for="remember"
							>Remember me</label
						>
					</div>
					<p class="text-gray-50">
						Don't have an account?
						<Link
							class="text-sm text-blue-500 hover:underline mt-4"
							href="/register"
							v-text="'Register'" />
					</p>
				</div>
				<button
					class="bg-gradient-to-r from-sky-700 to-sky-400 text-white font-bold py-2 px-4 rounded-md mt-4 hover:from-sky-400 hover:to-sky-700 transition-all delay-1000 ease-in-out"
					type="submit">
					Login
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
	email: "",
	password: "",
	remember: false,
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
