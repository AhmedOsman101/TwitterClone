<template>
	<Layout>
		<Header class="Header" />
		<Tweet />
	</Layout>
</template>

<script setup>
import Tweet from "../Components/Tweet.vue";
import Header from "../Components/Header.vue";
</script>

<style>
.Header {
	grid-area: header !important;
}
</style>
