<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { computed, toRaw } from "vue";
import TweetSingle from "@/Components/TweetSingle.vue";
import { useFeedStore } from "@/stores/feedStore.js";

const page = usePage();

const tweet = computed(() => toRaw(page.props.tweet.data));

const feedStore = useFeedStore();

feedStore.setFeed(tweet.value);

</script>

<template>
  <AuthenticatedLayout>
    <Head :title="`${tweet[0].user.full_name} on Twitter`"/>
    <Header :backable="true" :title="'Post'" class="Header"/>
    <section>
      <TweetSingle :tweet="tweet[0]"/>
    </section>
  </AuthenticatedLayout>
</template>

<style scoped>

section {
  grid-area: feed;
}

.Header {
  grid-area: header !important;
}

</style>