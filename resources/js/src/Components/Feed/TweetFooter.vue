<template>
  <div class="tweetFooter">
    <p class="footerItem hover:text-sky-500" @click.stop>
      <i class="fa-regular fa-comment-dots" />
      <span v-if="commentsCount" v-text="commentsCount" />
    </p>
    <p
      class="footerItem hover:text-pink-500"
      @click.stop="addLike($page.props.auth.user.id, tweet_id)"
    >
      <i class="fa-regular fa-heart" />
      <span v-if="likesCount" v-text="likesCount" />
    </p>
  </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

defineProps({ likesCount: Number, commentsCount: Number, tweet_id: Number });

const addLike = (user_id, tweet_id) => {
  router.post("like", { user_id, tweet_id });
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
