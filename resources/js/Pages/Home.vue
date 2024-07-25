<script setup lang="ts">
	import HomeTweet from "@/Components/CustomTextArea.vue";
	import Header from "@/Components/Header.vue";
	import Feed from "@/Components/Feed/Feed.vue";
	import Layout from "@/Layouts/AuthenticatedLayout.vue";
	import { Head } from "@inertiajs/vue3";
	import { useFeedStore } from "@/stores/feedStore.js";
	import { ITweet } from "@/lib/Interfaces";

	const feedStore = useFeedStore();

	const createTweet = (data: ITweet) => {
		feedStore.addNewTweet(data);
	};
</script>

<template>
	<Layout>
		<Head title="Twitter" />
		<Header class="Header" />
		<div>
			<HomeTweet
				:action="createTweet"
				:max-length="280" />
		</div>
		<Feed />
	</Layout>
</template>

<style>
	.Header {
		grid-area: header !important;
	}
</style>
