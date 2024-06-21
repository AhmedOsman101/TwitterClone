<template>
  <div class="tweetFooter">
    <p class="footerItem hover:text-sky-500">
      <i class="fa-regular fa-comment-dots" />
      <span v-if="tweet.comments_count" v-text="tweet.comments_count" />
    </p>

    <p
      class="footerItem hover:text-pink-500"
      @click.stop="addLike(user.id, $props.tweet_id)"
    >
      <i
        :class="{
          'fa-regular': !tweet.liked,
          'fa-solid': tweet.liked,
        }"
        class="fa-heart"
      />
      <span v-if="tweet.likes_count" v-text="tweet.likes_count" />
      <!--      <p class="bg-white text-black w-full" v-text="{ ...$props }"/>-->
    </p>
  </div>
</template>

<script setup>
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import { router } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import { computed } from "vue";

const props = defineProps({
  tweet_id: Number,
});

const authStore = useAuthStore();
const feedStore = useFeedStore();

const { user } = storeToRefs(authStore);
const { feed } = storeToRefs(feedStore);

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
      onSuccess: async () => {
        await feedStore.fetchTweet(tweet_id);
      },
    },
  );
};
</script>

<style scoped>
.tweetFooter {
  grid-area: footer;
  @apply flex gap-5 items-center;
}

.footerItem {
  @apply flex justify-between items-center gap-2 h-fit transition duration-500;
  font-size: 1.2rem;
}
</style>
