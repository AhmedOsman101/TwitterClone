<template>
  <section id="Tweets" class="grid">
    <div
      v-for="tweet in feed"
      :key="tweet.id"
      class="tweet pl-5 pt-5 thinBorder-b hover:bg-[#080808] cursor-pointer"
    >
      <div class="flex align-start gap-3">
        <Link
          :href="`/profile/${tweet.user.username}`"
          class="w-fit h-fit rounded-full"
        >
          <img
            :alt="tweet.user.fullname"
            :src="tweet.user.profile_picture"
            class="w-10 h-10 rounded-full bg-gray-500"
          />
        </Link>
        <Link
          :href="`/profile/${tweet.user.username}`"
          class="font-semibold text-gray-200"
          v-text="tweet.user.full_name"
        />
        <Link
          :href="`/profile/${tweet.user.username}`"
          class="font-semibold text-gray-400"
          v-text="`@${tweet.user.username}`"
        />
      </div>
      <p>{{ tweet.body }}</p>
    </div>
  </section>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, onMounted, watch } from "vue";

defineProps({ feed: Array });

const page = usePage();

const feed = computed(() => page.props.feed);

watch(feed, () => router.reload());

onMounted(() => {
  for (let tweet of feed.value) {
    const created = new Date(tweet.created_at);
    const updated = new Date(tweet.updated_at);
    const options = {
      year: "numeric",
      month: "short",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
    };

    tweet.created_at = created.toLocaleString("en-US", options);
    tweet.updated_at = updated.toLocaleString("en-US", options);
  }
});
</script>

<style scoped>
section {
  grid-area: feed;
}

.tweet {
  display: grid;
  grid-template-rows: 1fr 2fr 1fr;
  @apply min-h-full;
}
</style>
