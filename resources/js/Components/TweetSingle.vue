<script lang="ts" setup>
import TweetFooter from "@/Components/Feed/TweetFooter.vue";
import { ITweet } from "@/types";

defineProps<{
  tweet: ITweet;
}>();
</script>

<template>
  <div class="tweet pt-5 thinBorder-b">
    <div class="TweetTop">
      <Link
        :href="route('profile.index', tweet.user.username)"
        class="w-fit h-fit rounded-full image ml-5">
        <img
          :alt="tweet.user.full_name"
          :src="tweet.user.profilePicture"
          class="w-10 h-10 rounded-full bg-gray-500" />
      </Link>
      <div class="flex flex-col ml-2 tweetHead">
        <Link
          :href="route('profile.index', tweet.user.username)"
          class="font-semibold text-gray-200 hover:underline transition"
          v-text="tweet.user.full_name" />
        <Link
          :href="route('profile.index', tweet.user.username)"
          class="font-semibold text-gray-400 hover:underline transition -mt-0.5"
          v-text="`@${tweet.user.username}`" />
      </div>
    </div>

    <p
      class="pl-5 text-gray-400"
      v-text="tweet.created_at" />

    <p
      class="tweetBody pl-5 text-xs"
      v-text="tweet.body" />

    <TweetFooter :tweet="tweet" />
  </div>
</template>

<style scoped>
.tweet {
  display: grid;
  grid-template-rows: repeat(3, auto) 3rem;
  grid-template-columns: auto 1fr;
  gap: 0.8rem;
  grid-template-areas:
    "header header"
    "body body"
    "duration duration"
    "footer footer";
  @apply min-h-fit h-fit;
}

.tweetBody {
  grid-area: body;
  @apply text-lg font-semibold pr-1 whitespace-break-spaces;
}

.TweetTop {
  grid-area: header;
  display: grid;
  grid-template-areas: "image full_name btn";
  grid-template-columns: auto auto 1fr;
  place-items: center;
}
</style>
