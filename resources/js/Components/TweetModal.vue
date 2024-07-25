<script lang="ts" setup>
	import { ref } from "vue";
	import Modal from "./Modal.vue";
	import HomeTweet from "./CustomTextArea.vue";
	import { useFeedStore } from "@/stores/feedStore.js";

	const showModal = ref(false);

	const toggleModal = () => {
		showModal.value = !showModal.value;
	};

	const closeModal = () => {
		showModal.value = false;
	};

	const feedStore = useFeedStore();

	const createTweet = (data) => {
		feedStore.addNewTweet(data);
	};
</script>

<template>
	<button @click="toggleModal">
		<i class="fa-solid fa-feather" />
		<span class="hidden lg:block">Tweet</span>
	</button>

	<Modal
		:show="showModal"
		padding="py-8"
		@close="closeModal">
		<HomeTweet
			:action="createTweet"
			:max-length="280"
			@closeModal="closeModal" />
	</Modal>
</template>

<style scoped>
	button {
		@apply w-11
    text-white
    flex
    items-center
    rounded-full
    justify-center
    aspect-square
    hover:bg-sky-400
    transition
    duration-400
		text-base
		p-3
		lg:w-full
		lg:aspect-auto
    lg:font-bold 
    lg:capitalize 
    lg:gap-4 
    lg:px-5 
    lg:py-3 
		lg:text-xl
    lg:rounded-3xl
    bg-sky-500;
	}
</style>
