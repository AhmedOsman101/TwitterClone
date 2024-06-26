<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import { storeToRefs } from "pinia";
import { computed, watch } from "vue";
import FeedTweet from "@/Components/Feed/Tweet.vue";

const page = usePage();

const feedStore = useFeedStore();

// Set the feed data from Inertia props to Pinia store
feedStore.setFeed(page.props.feed);

const {feed} = storeToRefs(feedStore);

const feedLength = computed(() => feed.value.length);

watch(feedLength, () => {
  feedStore.getFeed();
});

</script>

<template>
  <section id="Tweets" class="grid">
    <FeedTweet
        v-for="tweet in feed"
        :key="tweet.id"
        :tweet="tweet"
        />
  </section>
</template>

<style scoped>
section {
  grid-area: feed;
}
</style>
