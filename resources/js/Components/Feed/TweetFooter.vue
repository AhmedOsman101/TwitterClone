-- Active: 1721839829348@@127.0.0.1@3306
<script setup>
	import { useAuthStore } from "@/stores/authStore.js";
	import { storeToRefs } from "pinia";
	import { useFeedStore } from "@/stores/feedStore.js";
	import { computed } from "vue";
	import { formatNumber } from "@/Helpers.js";

	const props = defineProps({
		tweet: {
			type: Object,
			required: true,
		},
		isProfile: {
			type: Boolean,
			default: false,
		},
	});

	const authStore = useAuthStore();
	const feedStore = useFeedStore();

	const { user } = storeToRefs(authStore);
	const { feed } = storeToRefs(feedStore);

	const tweetIndex = computed(() => {
		return feed.value.findIndex((item) => item.id === props.tweet_id);
	});

	const tweet = computed(() => feed.value[tweetIndex.value] || props.tweet);

	/**
	 * The `addLike` function is responsible for sending a POST request to the server to like a tweet.
	 *
	 * It re-fetches the tweet and the user to update tweet's likes count and refresh notifications.
	 * @param {number} user_id
	 * @param {number} tweet_id
	 */
	const addLike = (user_id, tweet_id) => {
		const data = {
			user_id,
			tweet_id,
			isTweet: true,
		};

		axios.post(route("like.store"), data).then(() => {
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

		<p
			class="footerItem text-gray-400 hover:text-pink-500"
			@click.prevent="addLike(user.id, $props.tweet.id)">
			<i
				:class="{
					'fa-regular': !tweet.liked,
					'fa-solid text-pink-500': tweet.liked,
				}"
				class="fa-heart" />
			<span
				v-if="tweet.likes_count"
				v-text="formatNumber(tweet.likes_count)" />
		</p>
	</div>
</template>

<style scoped>
	.tweetFooter {
		grid-area: footer;
		@apply flex gap-5 items-center relative pl-5 thinBorder-t;
	}

	/* .tweetFooter::after {
		content: "";
		position: absolute;
		width: calc(100% + 21px);
		height: 1px;
		top: 0;
		left: -21px;
		@apply thinBorder-t;
		border-color: #6b7280 !important;
	} */

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
