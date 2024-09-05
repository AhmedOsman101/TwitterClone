<script setup lang="ts">
  import Comment from "@/Components/Comment.vue";
  import Tweet from "@/Components/Feed/Tweet.vue";
  import Header from "@/Components/Header.vue";
  import OptionsBar from "@/Components/OptionsBar.vue";
  import NoLikes from "@/Components/Placeholders/NoLikes.vue";
  import NoReplies from "@/Components/Placeholders/NoReplies.vue";
  import NoTweets from "@/Components/Placeholders/NoTweets.vue";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { isEmptyArray } from "@/lib/Helpers";
  import ProfileMain from "@/Pages/Profile/Partials/ProfileMain.vue";
  import { useGlobalState } from "@/stores/globalDataStore.js";
  import { useProfileStore } from "@/stores/profileStore.js";
  import { IComment, ITweet, ProfileStore, User } from "@/types";
  import { ProfileOptions } from "@/types/Enums";
  import { Head, usePage } from "@inertiajs/vue3";
  import { computed } from "vue";

  interface PageProps {
    allPosts: ITweet[];
    likedPosts: ITweet[];
    replies: IComment[];
    user: User;
    [key: string]: any;
  }

  const page = usePage<PageProps>();

  const profileStore: ProfileStore = useProfileStore();
  const globalState = useGlobalState();

  profileStore.setFeed(ProfileOptions.Posts, page.props.allPosts);
  profileStore.setFeed(ProfileOptions.Likes, page.props.likedPosts);
  profileStore.setFeed(ProfileOptions.Replies, page.props.replies);

  const user = computed(() => page.props.user);

  console.log(user.value, "user");

  // console.log(toRaw(profileStore.posts));
  // console.log(toRaw(profileStore.liked));
  // console.log(toRaw(profileStore.replies));
</script>

<template>
  <AuthenticatedLayout>
    <Header
      :backable="true"
      :title="user.full_name" />
    <Head :title="`${user.full_name} | (@${user.username})`" />
    <ProfileMain />
    <section class="grid">
      <OptionsBar
        :options="['posts', 'replies', 'likes']"
        type="profile" />
      <Tweet
        v-for="tweet in profileStore.posts"
        v-if="
          !isEmptyArray(profileStore.posts) &&
          globalState.activeProfileOption.value === ProfileOptions.Posts
        "
        :key="tweet.id"
        :tweet="tweet" />

      <Comment
        v-for="comment in profileStore.replies"
        v-if="
          !isEmptyArray(profileStore.replies) &&
          globalState.activeProfileOption.value === ProfileOptions.Replies
        "
        :key="comment.id"
        :comment="comment" />

      <Tweet
        v-for="tweet in profileStore.liked"
        v-if="
          !isEmptyArray(profileStore.liked) &&
          globalState.activeProfileOption.value === ProfileOptions.Likes
        "
        :key="tweet.id"
        :tweet="tweet" />

      <NoTweets
        v-if="
          isEmptyArray(profileStore.posts) &&
          globalState.activeProfileOption.value === ProfileOptions.Posts
        "
        :full_name="user.full_name"
        class="my-5" />

      <NoReplies
        v-if="
          isEmptyArray(profileStore.replies) &&
          globalState.activeProfileOption.value === ProfileOptions.Replies
        "
        :full_name="user.full_name"
        class="my-5" />

      <NoLikes
        v-if="
          isEmptyArray(profileStore.liked) &&
          globalState.activeProfileOption.value === ProfileOptions.Likes
        "
        :full_name="user.full_name"
        class="my-5" />
    </section>
  </AuthenticatedLayout>
</template>
