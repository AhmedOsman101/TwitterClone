<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import HomeTweet from "@/Components/HomeTweet.vue";
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
	<button
		class="text-white text-xl font-bold text-capitalize items-center gap-4 bg-sky-500 px-5 py-3 rounded-3xl w-full flex justify-center ml-[-1rem]"
		@click="toggleModal">
		<i class="fa-solid fa-feather" />
		Tweet
	</button>

	<Modal :show="showModal" padding="py-8" @close="closeModal">
		<HomeTweet
			@closeModal="closeModal"
			:maxLength="280"
			:action="createTweet" />
	</Modal>
</template>
