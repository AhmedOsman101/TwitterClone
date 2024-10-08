<script setup>
	import { computed, onMounted, onUnmounted, ref } from "vue";
	import { usePage } from "@inertiajs/vue3";
	import { getComponent } from "@/lib/Helpers";

	defineProps({ title: String, backable: Boolean });

	const page = usePage();

	const head = ref(null);
	const component = computed(() => getComponent(page));

	onMounted(() => {
		head?.value.focus();
		// Attach the scroll event listener when the component is mounted
		window.addEventListener("scroll", handleScroll);
	});

	onUnmounted(() => {
		// Remove the scroll event listener when the component is unmounted
		window.removeEventListener("scroll", handleScroll);
	});

	/**
	 * Apply a blur filter along with a transparent background on scroll.
	 */
	const handleScroll = () => {
		const scrollY = window.scrollY; // Get the Y-axis scroll position

		if (scrollY !== 0) {
			head.value.style.background = "rgb(0, 0, 0, 0.5)";
			head.value.style.backdropFilter = "blur(10px)";
		} else {
			head.value.style.background = "rgb(0, 0, 0)";
			head.value.style.backdropFilter = "none";
		}
	};

	/**
	 * Go back to the previous page and re-fetch user to update notifications.
	 */
	const back = () => window.history.back();
</script>

<template>
	<section
		ref="head"
		class="pl-5 py-4 thinBorder-b sticky top-0 bg-black z-50">
		<div class="flex gap-4 items-center w-full">
			<button
				v-if="backable"
				class="p-3 aspect-square grid place-items-center rounded-full hover:bg-[#181919]"
				@click="back">
				<i class="fa-solid fa-arrow-left" />
			</button>
			<h1 class="text-xl font-bold">{{ $props.title ?? component }}</h1>
		</div>
	</section>
</template>
