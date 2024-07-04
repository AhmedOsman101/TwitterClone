<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProfileMain from "@/Pages/Profile/ProfileMain.vue";
import Tweet from "@/Components/Feed/Tweet.vue";
import Header from "@/Components/Header.vue";
import NoTweets from "@/Components/Placeholders/NoTweets.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useFeedStore } from "@/stores/feedStore.js";
import { storeToRefs } from "pinia";
import OptionsBar from "@/Components/OptionsBar.vue";
import { useGlobalState } from "@/stores/globalDataStore.js";
import NoLikes from "@/Components/Placeholders/NoLikes.vue";
import NoReplies from "@/Components/Placeholders/NoReplies.vue";

const page = usePage();

const feedStore = useFeedStore();

// Set the feed data from Inertia props to Pinia store
feedStore.setFeed(page.props.feed);

const {feed} = storeToRefs(feedStore);

const globalState = useGlobalState();

</script>

<template>
  <AuthenticatedLayout>
    <Header :backable="true" :title="$page.props.user.full_name"/>
    <Head :title="`${$page.props.user.full_name} | (@${$page.props.user.username})`"/>
    <ProfileMain/>
    <section class="grid">
      <OptionsBar :options="['posts', 'replies', 'likes']" type="profile"/>
      <Tweet
          v-for="tweet in feed"
          v-if="feed.length > 0"
          :key="tweet.id"
          :tweet="tweet"
      />
      <NoTweets v-if="feed.length === 0 && globalState.activeProfileOption.value === 'posts'"
                :full_name="$page.props.user.full_name" class="my-5"/>

      <NoLikes v-if="feed.length === 0 && globalState.activeProfileOption.value === 'likes'"
               :full_name="$page.props.user.full_name" class="my-5"/>

      <NoReplies v-if="feed.length === 0 && globalState.activeProfileOption.value === 'replies'"
                 :full_name="$page.props.user.full_name" class="my-5"/>
    </section>
  </AuthenticatedLayout>
</template>


