<template>
	<section id="Tweets" class="grid">
		<div
			v-for="tweet in feed"
			:key="tweet.id"
			@click="() => redirectToPost(tweet.id)"
			class="tweet pl-5 pt-5 thinBorder-b hovered cursor-pointer">
			<div class="flex align-start gap-3 tweetHead">
				<Link
					:href="`/profile/${tweet.user.username}`"
					class="w-fit h-fit rounded-full">
					<img
						:alt="tweet.user.full_name"
						:src="tweet.user.profile_picture"
						class="w-10 h-10 rounded-full bg-gray-500" />
				</Link>
				<Link
					:href="`/profile/${tweet.user.username}`"
					class="font-semibold text-gray-200"
					v-text="tweet.user.full_name" />
				<Link
					:href="`/profile/${tweet.user.username}`"
					class="font-semibold text-gray-400"
					v-text="`@${tweet.user.username}`" />
			</div>

			<p class="tweetBody" v-text="tweet.body" />
		</div>
	</section>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, watch } from "vue";

const page = usePage();

const feed = computed(() => page.props.feed);

const redirectToPost = (id) => {
	return router.get(`tweets/${id}`);
};

watch(feed, () => router.reload());

// onMounted(() => {
//   for (let tweet of feed.value) {
//     const created = new Date(tweet.created_at);
//     const updated = new Date(tweet.updated_at);
//     const options = {
//       year: "numeric",
//       month: "short",
//       day: "numeric",
//       hour: "numeric",
//       minute: "numeric",
//       second: "numeric",
//     };
//
//     tweet.created_at = created.toLocaleString("en-US", options);
//     tweet.updated_at = updated.toLocaleString("en-US", options);
//   }
// });
</script>

<style scoped>
section {
	grid-area: feed;
}

.tweet {
	display: grid;
	grid-template-rows: 3rem auto 3rem;
	row-gap: 1rem;
	grid-template-areas:
		"header"
		"body"
		"footer";
	@apply min-h-fit h-fit;
}

.tweetHead {
	grid-area: header;
}

.tweetBody {
	grid-area: body;
	@apply text-lg font-semibold;
}

.hovered:hover {
	background-color: #04070e;
}
</style>
