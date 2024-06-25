<script setup>
import AddComment from "@/Components/AddComment.vue";
import Comment from "@/Components/Comment.vue";
import { useCommentStore } from "@/stores/commentStore.js";
import { storeToRefs } from "pinia";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const commentStore = useCommentStore();

const page = usePage();

onMounted(() => {
  commentStore.getComments(page.props.tweet[0].id);
});

const {comments} = storeToRefs(commentStore);

</script>

<template>
  <AddComment/>
  <Comment
      v-for="comment in comments"
      :key="comment.id"
      :comment="comment"/>
</template>

<style scoped>

</style>