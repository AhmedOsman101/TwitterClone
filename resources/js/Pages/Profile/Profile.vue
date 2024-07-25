<script setup lang="ts">
	import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
	import ProfileMain from "@/Pages/Profile/Partials/ProfileMain.vue";
	import Header from "@/Components/Header.vue";
	import OptionsBar from "@/Components/OptionsBar.vue";
	import Tweet from "@/Components/Feed/Tweet.vue";
	import Comment from "@/Components/Comment.vue";
	import NoTweets from "@/Components/Placeholders/NoTweets.vue";
	import NoLikes from "@/Components/Placeholders/NoLikes.vue";
	import NoReplies from "@/Components/Placeholders/NoReplies.vue";
	import { Head, usePage } from "@inertiajs/vue3";
	import { useGlobalState } from "@/stores/globalDataStore.js";
	import { useProfileStore } from "@/stores/profileStore.js";
	import { computed } from "vue";
	import { ProfileOptions } from "@/lib/Enums";
	import { ProfileStore } from "@/lib/Types";
	import { ITweet, IUser } from "@/lib/Interfaces";

	const page = usePage();

	const profileStore: ProfileStore = useProfileStore();
	const globalState = useGlobalState();

	profileStore.setFeed(ProfileOptions.Posts, page.props.allPosts as ITweet[]);
	profileStore.setFeed(
		ProfileOptions.Likes,
		page.props.likedPosts as ITweet[]
	);
	profileStore.setFeed(
		ProfileOptions.Replies,
		page.props.replies as ITweet[]
	);

	const user = computed(() => page.props.user as IUser);

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
					profileStore.posts.length !== 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Posts
				"
				:key="tweet.id"
				:tweet="tweet" />

			<Comment
				v-for="comment in profileStore.replies"
				v-if="
					profileStore.replies.length !== 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Replies
				"
				:key="comment.id"
				:comment="comment" />

			<Tweet
				v-for="tweet in profileStore.liked"
				v-if="
					profileStore.liked.length !== 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Likes
				"
				:key="tweet.id"
				:tweet="tweet" />

			<NoTweets
				v-if="
					profileStore.posts.length === 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Posts
				"
				:full_name="user.full_name"
				class="my-5" />

			<NoReplies
				v-if="
					profileStore.replies.length === 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Replies
				"
				:full_name="user.full_name"
				class="my-5" />

			<NoLikes
				v-if="
					profileStore.liked.length === 0 &&
					globalState.activeProfileOption.value ===
						ProfileOptions.Likes
				"
				:full_name="user.full_name"
				class="my-5" />
		</section>
	</AuthenticatedLayout>
</template>
