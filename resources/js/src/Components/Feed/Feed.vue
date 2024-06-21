<template>
  <section id="Tweets" class="grid">
    <FeedTweet
      v-for="tweet in feed"
      :key="tweet.id"
      :tweet="tweet"
      @click="() => redirectToPost(tweet.id)"
    />
  </section>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import FeedTweet from "@/src/Components/Feed/Tweet.vue";
import { storeToRefs } from "pinia";
import { watch } from "vue";

const page = usePage();

const feedStore = useFeedStore();

// Set the feed data from Inertia props to Pinia store
feedStore.setHomeFeed(page.props.feed.data);

const { feed } = storeToRefs(feedStore);

watch(feed, () => {
  feedStore.getHomeFeed();
});

const redirectToPost = (id) => {
  router.get(`tweets/${id}`);
};
</script>

<style scoped>
section {
  grid-area: feed;
}
</style>
