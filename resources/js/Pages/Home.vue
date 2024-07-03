<script setup>
import HomeTweet from "@/Components/HomeTweet.vue";
import Header from "@/Components/Header.vue";
import Feed from "@/Components/Feed/Feed.vue";
import Layout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Layout>

    <Head title="Twitter"/>
    <Header class="Header"/>
    <div>
      <HomeTweet class="pt-4 thinBorder-b"/>
    </div>
    <Feed/>

  </Layout>
</template>

<style>
.Header {
  grid-area: header !important;
}
</style>
