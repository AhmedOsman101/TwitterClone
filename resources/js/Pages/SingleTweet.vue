<script setup lang="ts">
	import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
	import Header from "@/Components/Header.vue";
	import { Head, usePage } from "@inertiajs/vue3";
	import { computed } from "vue";
	import TweetSingle from "@/Components/TweetSingle.vue";
	import { useFeedStore } from "@/stores/feedStore";
	import CommentSection from "@/Components/CommentSection.vue";
	import { ITweet, FeedStore } from "@/types";

	defineOptions({ layout: AuthenticatedLayout });

	const page = usePage();

	const tweet = computed(() => page.props.tweet as ITweet);

	const feedStore: FeedStore = useFeedStore();

	feedStore.setFeed([tweet.value]);
</script>

<template>
	<Head :title="`${tweet.user.full_name} on Twitter`" />
	<Header
		:backable="true"
		:title="'Post'"
		class="Header" />
	<section>
		<TweetSingle :tweet="tweet" />
		<CommentSection />
	</section>
</template>

<style scoped>
	section {
		grid-area: feed;
	}

	.Header {
		grid-area: header !important;
	}
</style>
