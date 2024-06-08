<template>
	<section class="pl-5 py-4 border-b">
		<div class="flex gap-4 items-center w-full">
			<button @click="back" v-if="component !== 'Home'">
				<i class="fa-solid fa-arrow-left" />
			</button>
			<h1 class="text-lg font-bold">{{ component }}</h1>
		</div>
	</section>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();

const component = computed(() => getComponent(page));

const getComponent = (page) => {
	let component = page.component;
	component = component.split("/");
	const index = component.length - 1;
	component = component[index];
	console.log(component);
	return component;
};

const back = () => {
	// Go back to the previous page
	window.history.back();
};
</script>

<style scoped></style>
