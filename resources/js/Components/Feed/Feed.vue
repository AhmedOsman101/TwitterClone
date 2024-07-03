<script setup>
import { usePage } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import { storeToRefs } from "pinia";
import { computed, watch } from "vue";
import FeedTweet from "@/Components/Feed/Tweet.vue";
import EmptyFeed from "@/Components/Placeholders/EmptyFeed.vue";

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
  <section class="grid">
    <FeedTweet
        v-for="tweet in feed"
        v-if="feedLength > 0"
        :key="tweet.id"
        :tweet="tweet"
    />
    <EmptyFeed v-else/>
  </section>
</template>

<style scoped>
section {
  grid-area: feed;
}
</style>
