<template>
	<Layout>
		<Header class="Header" />
		<Tweet />
		<Feed />
	</Layout>
</template>

<script setup>
import Tweet from "../Components/Tweet.vue";
import Header from "../Components/Header.vue";
import Feed from "./Tweets/index.vue";
</script>

<style>
.Header {
	grid-area: header !important;
}
</style>
