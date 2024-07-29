<script lang="ts" setup>
	import { useAuthStore } from "@/stores/authStore.js";
	import { storeToRefs } from "pinia";
	import { useFeedStore } from "@/stores/feedStore.js";
	import { computed } from "vue";
	import { formatNumber } from "@/lib/Helpers";
	import { AuthStore, FeedStore, ITweet } from "@/types";
	import { useAxios } from "@vueuse/integrations/useAxios";

	const props = withDefaults(
		defineProps<{
			tweet: ITweet;
			isProfile?: boolean;
		}>(),
		{ isProfile: false }
	);

	const authStore: AuthStore = useAuthStore();
	const feedStore: FeedStore = useFeedStore();

	const { feed } = storeToRefs(feedStore);

	const tweetIndex = computed(() => {
		return feed.value.findIndex((item) => item.id === props.tweet.id);
	});

	const tweet = computed(() => feed.value[tweetIndex.value] || props.tweet);

	/**
	 * The `addLike` function is responsible for sending a POST request to the server to like a tweet.
	 *
	 * It re-fetches the tweet and the user to update tweet's likes count and refresh notifications.
	 * @param {number} tweet_id
	 */
	const addLike = (tweet_id: number) => {
		const data = {
			tweet_id,
			isTweet: true,
		};
		useAxios(route("like.store"), {
			data,
			method: "POST",
		}).then(() => {
			feedStore.fetchTweet(tweet_id);
			authStore.fetchUser();
		});
	};
</script>

<template>
	<div class="tweetFooter">
		<p class="footerItem text-gray-400 hover:text-sky-500">
			<i class="fa-regular fa-comment-dots" />
			<span
				v-if="tweet.comments_count"
				v-text="formatNumber(tweet.comments_count)" />
		</p>

		<button
			class="footerItem text-gray-400 hover:text-pink-500"
			@click.prevent="addLike(tweet.id)">
			<i
				:class="{
					'fa-regular': !tweet.liked,
					'fa-solid text-pink-500': tweet.liked,
				}"
				class="fa-heart" />
			<span
				v-if="tweet.likes_count"
				v-text="formatNumber(tweet.likes_count)" />
		</button>
	</div>
</template>

<style scoped>
	.tweetFooter {
		grid-area: footer;
		@apply flex 
		gap-5 
		items-center 
		relative 
		pl-5 
		thinBorder-t;
	}

	.footerItem {
		@apply flex 
    justify-between 
    items-center 
    gap-2 
    h-fit 
    transition 
    duration-500 
    cursor-pointer;
	}
</style>
