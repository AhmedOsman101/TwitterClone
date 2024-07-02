<script setup>

const props = defineProps({notification: Object});



</script>

<template>
  <div class="tweet pl-5 pt-5 thinBorder-b hovered cursor-pointer">
    <Link
        :href="route('profile.index', notification.username)"
        class="w-fit h-fit rounded-full image">
      <img
          :alt="notification.full_name"
          :src="notification.profile_picture"
          class="w-10 h-10 rounded-full bg-gray-500"/>
    </Link>
    <div class="flex align-start gap-3 tweetHead">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold text-gray-200 hover:underline transition"
          v-text="notification.full_name"/>
    </div>
    <p class="tweetBody" v-text="notification.message"/>
  </div>
</template>

<style scoped>
.tweet {
  display: grid;
  grid-template-rows: auto auto 3rem;
  grid-template-columns: auto 1fr;
  gap: 0.8rem;
  grid-template-areas:
		"image header"
    "body body";
  @apply min-h-fit h-fit;
}

.tweetHead {
  grid-area: header;
}

.tweetBody {
  grid-area: body;
  @apply text-lg font-semibold pr-1 whitespace-break-spaces;
}

.hovered:hover {
  background-color: #04070e;
}
</style>