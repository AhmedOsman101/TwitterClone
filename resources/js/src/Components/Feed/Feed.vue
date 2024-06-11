<template>
	<section id="Tweets" :key="componentKey" class="grid">
		<FeedTweet
			v-for="tweet in feed"
			:key="tweet.id"
			:tweet="tweet"
			@click="() => redirectToPost(tweet.id)" />
	</section>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import FeedTweet from "@/src/Components/Feed/Tweet.vue";

const page = usePage();

const componentKey = ref(0);

const feed = computed(() => page.props.feed);

const feedLength = computed(() => page.props.feed.length);

watch(feedLength, () => componentKey.value++);

const redirectToPost = (id) => {
	return router.get(`tweets/${id}`);
};
</script>

<style scoped>
section {
	grid-area: feed;
}
</style>
