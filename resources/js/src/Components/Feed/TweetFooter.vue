<template>
  <div class="tweetFooter">
    <p class="footerItem hover:text-sky-500">
      <i class="fa-regular fa-comment-dots" />
      <span v-if="commentsCount" v-text="commentsCount" />
    </p>
    <span v-text="{ ...$props, liked }" />

    <p
      class="footerItem hover:text-pink-500"
      @click.stop="addLike(user.id, tweet_id)"
    >
      <i
        :class="{
          'fa-regular': !liked,
          'fa-solid': liked,
        }"
        class="fa-heart"
      />
      <span v-if="likesCount" v-text="likesCount" />
    </p>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";

const props = defineProps({
  likesCount: Number,
  commentsCount: Number,
  tweet_id: Number,
});

const liked = ref(false); // Default to false until verified

const authStore = useAuthStore();

onMounted(() => authStore.getAuthenticatedUser());

const { user } = storeToRefs(authStore);

// Simplify the data sent to the server to avoid circular references
const getNotLiked = async () => {
  try {
    const response = await axios.post("http://localhost:8000/like", {
      user_id: user.id,
      tweet_id: props.tweet_id,
    });
    liked.value = response.data.liked;
  } catch (error) {
    console.error("Error fetching like status:", error.message);
  }
};

// Use Inertia's visit method for Inertia post requests
const addLike = async (user_id, tweet_id) => {
  try {
    const response = await axios.post("http://localhost:8000/like", {
      user_id,
      tweet_id,
      create: true,
    });
    liked.value = response.data.liked;
  } catch (error) {
    console.error("Error adding like:", error.message);
  }
};

onMounted(() => {
  getNotLiked();
});
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
