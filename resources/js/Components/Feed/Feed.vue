<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import FeedTweet from "@/Components/Feed/Tweet.vue";
import { storeToRefs } from "pinia";
import { computed, watch } from "vue";

const page = usePage();

const feedStore = useFeedStore();

// Set the feed data from Inertia props to Pinia store
feedStore.setHomeFeed(page.props.feed.data);

const { feed } = storeToRefs(feedStore);

const feedLength = computed(() => feed.value.length);

watch(feedLength, () => {
	feedStore.getHomeFeed();
});

const redirectToPost = (id) => {
	router.get(`tweets/${id}`);
};
</script>

<template>
	<section id="Tweets" class="grid">
		<FeedTweet
			v-for="tweet in feed"
			:key="tweet.id"
			:tweet="tweet"
			@click="() => redirectToPost(tweet.id)" />
	</section>
</template>

<style scoped>
section {
	grid-area: feed;
}
</style>
