<script lang="ts" setup>
import Comment from "@/Components/Comment.vue";
import CustomTextArea from "@/Components/CustomTextArea.vue";
import { useAuthStore } from "@/stores/authStore.js";
import { useCommentStore } from "@/stores/commentStore.js";
import { ITweet } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { storeToRefs } from "pinia";
import { onMounted, ref } from "vue";

const commentStore = useCommentStore();

const authStore = useAuthStore();

const page = usePage();

const tweet = ref(page.props.tweet as ITweet);

console.log(page.props.tweet);

onMounted(() => {
  commentStore.getComments(tweet.value.id);
});

const { comments } = storeToRefs(commentStore);

/**
 * The `createComment` function is responsible for creating a new comment.
 *
 * It re-fetches the user to refresh his notifications.
 */
const createComment = (body: string) => {
  commentStore.addNewComment({
    body,
    tweetId: tweet.value.id,
    targetId: tweet.value.userId,
  });

  authStore.fetchUser();
};
</script>

<template>
  <CustomTextArea
    :action="createComment"
    :max-length="255"
    :place-holder="'Post your reply'"
    Label="Reply" />
  <Comment
    v-for="comment in comments"
    :key="comment.id"
    :comment="comment" />
</template>
