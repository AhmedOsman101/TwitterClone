<template>
  <Layout>
    <Header class="Header" />
    <Tweet />
    <Feed />
  </Layout>
</template>

<script setup>
import Tweet from "../Components/HomeTweet.vue";
import Header from "../Components/Header.vue";
import Feed from "../Components/Feed/Feed.vue";
import Layout from "@/src/Layout/Layout.vue";
</script>

<style>
.Header {
  grid-area: header !important;
}
</style>
