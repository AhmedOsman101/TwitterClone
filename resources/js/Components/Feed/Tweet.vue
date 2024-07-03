<script setup>
import TweetFooter from "@/Components/Feed/TweetFooter.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({ tweet: Object });


const redirectToPost = (id) => {
	router.get(route("tweet.show", id));
};
</script>

<template>
	<Link
		class="tweet pl-5 pt-5 thinBorder-b hovered cursor-pointer"
		:href="route('tweet.show', tweet.id)">
		<Link
			:href="route('profile.index', tweet.user.username)"
			class="w-fit h-fit rounded-full image">
			<img
				:alt="tweet.user.full_name"
				:src="tweet.user.profile_picture"
				class="w-10 h-10 rounded-full bg-gray-500" />
		</Link>
		<div class="flex align-start gap-3 tweetHead">
			<Link
				:href="route('profile.index', tweet.user.username)"
				class="font-semibold text-gray-200 hover:underline transition"
				v-text="tweet.user.full_name" />
			<Link
				:href="route('profile.index', tweet.user.username)"
				class="font-semibold text-gray-400 hover:underline transition"
				v-text="`@${tweet.user.username}`" />
			<span class="text-gray-400">•</span>
			<p class="font-semibold text-gray-400" v-text="tweet.duration" />
		</div>

		<p class="tweetBody" v-text="tweet.body" />

		<TweetFooter :tweet_id="tweet.id" />
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
		"image body"
		"image footer";
	@apply min-h-fit h-fit;
}

.image {
	grid-area: image;
}

.tweetHead {
	grid-area: header;
}

.tweetBody {
	grid-area: body;
	@apply text-lg font-semibold pr-1 whitespace-break-spaces;
}

.hovered:hover {
	background-color: #04070e;
}
</style>
