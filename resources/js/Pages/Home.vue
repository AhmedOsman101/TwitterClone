<script setup lang="ts">
  import HomeTweet from "@/Components/CustomTextArea.vue";
  import Feed from "@/Components/Feed/Feed.vue";
  import Header from "@/Components/Header.vue";
  import Layout from "@/Layouts/AuthenticatedLayout.vue";
  import { useFeedStore } from "@/stores/feedStore.js";
  import { FeedStore, ITweet } from "@/types";
  import { Head } from "@inertiajs/vue3";

  const feedStore: FeedStore = useFeedStore();

  const createTweet = (data: ITweet) => {
    feedStore.addNewTweet(data.body);
  };
</script>

<template>
  <Layout>
    <Head title="Twitter" />
    <Header class="Header" />
    <div>
      <HomeTweet
        :action="createTweet"
        :max-length="280" />
    </div>
    <Feed />
  </Layout>
</template>

<style>
  .Header {
    grid-area: header !important;
  }
</style>
