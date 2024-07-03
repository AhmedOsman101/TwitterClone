<script setup>
import { ref } from "vue";

const feedType = ref("forYou");

const setFeedType = (type) => {
	feedType.value = type;
};
</script>

<template>
	<!-- Header -->
	<div class="flex w-full thinBorder-b">
		<div
			class="flex justify-center flex-1 p-3 hover:bg-gray-950 transition duration-300 cursor-pointer relative thinBorder-r"
			@click="setFeedType('forYou')">
			For you
			<div
				v-if="feedType === 'forYou'"
				class="absolute bottom-0 w-10 h-1 rounded-full bg-sky-400" />
		</div>
		<div
			class="flex justify-center flex-1 p-3 hover:bg-gray-950 transition duration-300 cursor-pointer relative"
			@click="setFeedType('following')">
			Following
			<div
				v-if="feedType === 'following'"
				class="absolute bottom-0 w-10 h-1 rounded-full bg-sky-400" />
		</div>
	</div>
</template>
