<template>
  <div
    class="tweet pl-5 pt-5 thinBorder-b hovered cursor-pointer"
    @click="() => redirectToPost(tweet.id)"
  >
    <div class="flex align-start gap-3 tweetHead">
      <Link
        :href="`/profile/${tweet.user.username}`"
        class="w-fit h-fit rounded-full"
      >
        <img
          :alt="tweet.user.full_name"
          :src="tweet.user.profile_picture"
          class="w-10 h-10 rounded-full bg-gray-500"
        />
      </Link>
      <Link
        :href="`/profile/${tweet.user.username}`"
        class="font-semibold text-gray-200 hover:underline transition"
        v-text="tweet.user.full_name"
      />
      <Link
        :href="`/profile/${tweet.user.username}`"
        class="font-semibold text-gray-400 hover:underline transition"
        v-text="`@${tweet.user.username}`"
      />
      <span class="text-gray-400">•</span>
      <p class="font-semibold text-gray-400" v-text="tweet.duration" />
    </div>

    <p class="tweetBody" v-text="tweet.body" />
  </div>
</template>
<script setup>
defineProps({ tweet: Object });
</script>
<style scoped>
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
