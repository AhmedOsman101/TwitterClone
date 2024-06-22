<script setup>
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import { router } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import { computed } from "vue";
import { formatNumber } from "@/Helpers.js";

const props = defineProps({tweet_id: Number});

const authStore = useAuthStore();
const feedStore = useFeedStore();

const {user} = storeToRefs(authStore);
const {feed} = storeToRefs(feedStore);

const tweetIndex = computed(() =>
                                feed.value.findIndex((item) => item.id === props.tweet_id),
);

const tweet = computed(() => feed.value[tweetIndex.value]);

const addLike = (user_id, tweet_id) => {
  router.post(
      "/like",
      {
        user_id,
        tweet_id,
      },
      {
        preserveScroll: true,
        onSuccess: () => {
          feedStore.fetchTweet(tweet_id);
        },
      },
  );
};
</script>

<template>
  <div class="tweetFooter">

    <p class="footerItem text-gray-400 hover:text-sky-500">
      <i class="fa-regular fa-comment-dots"/>
      <span v-if="tweet.comments_count" v-text="formatNumber(tweet.comments_count)"/>
    </p>

    <p
        class="footerItem text-gray-400 hover:text-pink-500"
        @click.stop="addLike(user.id, $props.tweet_id)">
      <i
          :class="{
					'fa-regular': !tweet.liked,
					'fa-solid text-pink-500': tweet.liked,
				}"
          class="fa-heart"/>
      <span v-if="tweet.likes_count" v-text="formatNumber(tweet.likes_count)"/>
    </p>
  </div>
</template>

<style scoped>
.tweetFooter {
  grid-area: footer;
  @apply flex gap-5 items-center;
}

.footerItem {
  @apply flex justify-between items-center gap-2 h-fit transition duration-500 cursor-pointer;
  font-size: 1rem;
}
</style>
