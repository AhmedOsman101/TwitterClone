<script setup>
import Comment from "@/Components/Comment.vue";
import { useCommentStore } from "@/stores/commentStore.js";
import { storeToRefs } from "pinia";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import HomeTweet from "./HomeTweet.vue";

const commentStore = useCommentStore();

const page = usePage();

onMounted(() => {
	commentStore.getComments(page.props.tweet[0].id);
});

const { comments } = storeToRefs(commentStore);

/**
 * The `createComment` function is responsible for creating a new comment.
 *
 * It re-fetches the user to refresh his notifications.
 */
const createComment = (data) => {
	commentStore.addNewComment({
		...data,
		tweet_id: page.props.tweet[0].id,
		target_id: page.props.tweet[0].user_id,
	});

	authStore.fetchUser();
};
</script>

<template>
	<HomeTweet :action="createComment" :maxLength="255" label="Reply" />
	<Comment v-for="comment in comments" :key="comment.id" :comment="comment" />
</template>
