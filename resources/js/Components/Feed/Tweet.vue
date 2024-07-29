<script lang="ts" setup>
	import TweetFooter from "@/Components/Feed/TweetFooter.vue";
	import { ITweet } from "@/types";

	const props = withDefaults(
		defineProps<{
			tweet: ITweet;
			isProfile?: boolean;
		}>(),
		{ isProfile: false }
	);
</script>

<template>
	<Link
		:href="route('tweet.show', tweet.id)"
		class="tweet hovered">
		<Link
			:href="route('profile.index', tweet.user.username)"
			class="w-fit h-fit rounded-full image">
			<img
				:alt="tweet.user.full_name"
				:src="tweet.user.profile_picture"
				class="w-10 h-10 rounded-full bg-gray-500" />
		</Link>
		<div class="tweetHead">
			<div class="flex flex-col lg:flex-row lg:gap-4">
				<Link
					:href="route('profile.index', tweet.user.username)"
					class="font-semibold text-gray-200"
					v-text="tweet.user.full_name" />
				<Link
					:href="route('profile.index', tweet.user.username)"
					class="text-gray-400 -mt-1 lg:-mt-0"
					v-text="`@${tweet.user.username}`" />
			</div>
			<span class="text-gray-400">•</span>
			<p
				class="font-semibold text-gray-400"
				v-text="tweet.duration" />
		</div>

		<p
			class="tweetBody"
			v-text="tweet.body" />
		<TweetFooter :tweet="tweet" />
	</Link>
</template>

<style scoped>
	.tweet {
		display: grid;
		grid-template-rows: auto auto 3rem;
		grid-template-columns: auto 1fr;
		gap: 0.8rem;
		grid-template-areas:
			"image header"
			"body body"
			"footer footer";
		@apply min-h-fit 
		h-fit 
		pt-5 
		lg:pt-3
		thinBorder-b;
	}

	.image {
		grid-area: image;
		@apply pl-5;
	}

	.tweetHead {
		grid-area: header;
		@apply flex 
		items-start 
		gap-3 
		text-sm
		lg:text-base
		lg:items-center;
	}

	.tweetBody {
		grid-area: body;
		@apply whitespace-break-spaces
    lg:text-lg 
    pr-1
		pl-5;
	}

	.hovered:hover {
		background-color: #04070e;
	}
</style>
