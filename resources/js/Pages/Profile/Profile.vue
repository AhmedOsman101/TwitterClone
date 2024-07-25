<script setup lang="ts">
	import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
	import ProfileMain from "@/Pages/Profile/Partials/ProfileMain.vue";
	import Header from "@/Components/Header.vue";
	import { Head, usePage } from "@inertiajs/vue3";
	import { useGlobalState } from "@/stores/globalDataStore.js";
	import { useProfileStore } from "@/stores/profileStore.js";
	import OptionsBar from "@/Components/OptionsBar.vue";
	import Tweet from "@/Components/Feed/Tweet.vue";
	import Comment from "@/Components/Comment.vue";
	import NoTweets from "@/Components/Placeholders/NoTweets.vue";
	import NoLikes from "@/Components/Placeholders/NoLikes.vue";
	import NoReplies from "@/Components/Placeholders/NoReplies.vue";
	import { toRaw } from "vue";

	const page = usePage();

	const profileStore = useProfileStore();
	const globalState = useGlobalState();

	profileStore.setFeed("posts", page.props.allPosts);
	profileStore.setFeed("likes", page.props.likedPosts);
	profileStore.setFeed("replies", page.props.replies);

	console.log(toRaw(profileStore.posts));
	console.log(toRaw(profileStore.liked));
	console.log(toRaw(profileStore.replies));
</script>

<template>
	<AuthenticatedLayout>
		<Header
			:backable="true"
			:title="$page.props.user.full_name" />
		<Head
			:title="`${$page.props.user.full_name} | (@${$page.props.user.username})`" />
		<ProfileMain />
		<section class="grid">
			<OptionsBar
				:options="['posts', 'replies', 'likes']"
				type="profile" />
			<Tweet
				v-for="tweet in profileStore.posts"
				v-if="
					profileStore.posts.length !== 0 &&
					globalState.activeProfileOption.value === 'posts'
				"
				:key="tweet.id"
				:tweet="tweet" />

			<Comment
				v-for="comment in profileStore.replies"
				v-if="
					profileStore.replies.length !== 0 &&
					globalState.activeProfileOption.value === 'replies'
				"
				:key="comment.id"
				:comment="comment" />

			<Tweet
				v-for="tweet in profileStore.liked"
				v-if="
					profileStore.liked.length !== 0 &&
					globalState.activeProfileOption.value === 'likes'
				"
				:key="tweet.id"
				:tweet="tweet" />

			<NoTweets
				v-if="
					profileStore.posts.length === 0 &&
					globalState.activeProfileOption.value === 'posts'
				"
				:full_name="$page.props.user.full_name"
				class="my-5" />

			<NoReplies
				v-if="
					profileStore.replies.length === 0 &&
					globalState.activeProfileOption.value === 'replies'
				"
				:full_name="$page.props.user.full_name"
				class="my-5" />

			<NoLikes
				v-if="
					profileStore.liked.length === 0 &&
					globalState.activeProfileOption.value === 'likes'
				"
				:full_name="$page.props.user.full_name"
				class="my-5" />
		</section>
	</AuthenticatedLayout>
</template>
