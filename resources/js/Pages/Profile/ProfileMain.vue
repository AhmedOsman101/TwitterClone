<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { useAuthStore } from "@/stores/authStore.js";

const page = usePage();

const user = computed(() => page.props.user);

const authStore = useAuthStore();

const addFollow = () => {
	axios
		.post(route("follower.store"), {
			follower_id: authStore.user.id,
			followed_user_id: user.value.id,
		})
		.then(() => router.reload());
};
</script>

<template>
	<section class="overflow-y-scroll thinBorder-b pb-4 mb-2">
		<div class="cover_container">
			<img :alt="user.username" :src="user.cover_photo" />
		</div>
		<div class="column-2-user-tab">
			<div class="flex flex-row justify-between px-5">
				<div>
					<img
						:alt="user.username"
						:src="user.profile_picture"
						class="w-32 rounded-full border-4 border-black mt-[-70px]" />
				</div>
				<div class="flex flex-row mt-2">
					<div v-if="!$page.props.canEdit" class="mr-2.5 mt-1.5">
						<button
							v-if="$page.props.isFollowing"
							class="bg-black text-lg text-gray-100 border border-gray-100 rounded-full px-3 py-1 font-bold"
							@click="addFollow">
							Following
						</button>
						<button
							v-else
							class="bg-gray-100 text-lg text-black border border-gray-100 rounded-full px-5 py-1 font-bold"
							@click="addFollow">
							Follow
						</button>
					</div>
					<div v-if="$page.props.canEdit" class="cta-4 mt-1.5">
						<Link
							:href="route('profile.edit', user.username)"
							as="button"
							>Edit profile</Link
						>
					</div>
				</div>
			</div>
			<div class="user-tab-2">
				<h2 v-text="user.full_name" />
				<div class="tab-2-handle">
					<p v-text="`@${user.username}`" />
					<span v-if="$page.props.isFollowed" class="text-black"
						>Follows you</span
					>
				</div>
			</div>
			<div class="user-tab-3">
				<div class="tab-3-third tab-3-item">
					<span>
						<i class="fa-regular fa-calendar" />
					</span>
					<p>Joined {{ user.created_at }}</p>
				</div>
			</div>
			<div class="user-tab-4">
				<a class="tab-4-item" href="#">
					<h2 v-text="user.following_count" />
					<span>Following</span>
				</a>
				<a class="tab-4-item" href="#">
					<h2 v-text="user.followers_count" />
					<span>Followers</span>
				</a>
			</div>
		</div>
	</section>
</template>

<style scoped>
.cover_container img {
	height: 100%;
	width: 100%;
	max-height: 220px !important;
	object-fit: cover;
	object-position: center;
}

.cover_container {
	width: 100% !important;
	max-width: 100% !important;
	max-height: 220px !important;
}

section::-webkit-scrollbar {
	display: none;
}

section {
	-ms-overflow-style: none; /* IE and Edge */
	scrollbar-width: none; /* Firefox */
}

.cta-4 button {
	@apply bg-black text-lg text-gray-100 border border-gray-100 rounded-full px-3 py-1 font-bold;
}

.user-tab-2 {
	@apply px-5 pt-2;
}

.user-tab-2 h2 {
	@apply text-gray-100 text-xl font-extrabold;
}

.tab-2-handle p {
	@apply text-gray-500 text-base font-normal inline-block mr-2.5;
}

.tab-2-handle span {
	@apply text-xs font-bold px-2 py-1 rounded-md;
	color: rgb(113, 118, 123);
	background: rgb(32, 35, 39);
}

.user-tab-3 {
	@apply flex flex-row px-5 pt-5;
}

.tab-3-item {
	@apply flex flex-row items-center mr-3;
}

.tab-3-item p {
	@apply text-gray-500 text-sm font-normal inline-block ml-2.5;
}

.user-tab-4 {
	@apply px-5 pt-2 flex flex-row;
}

.tab-4-item {
	@apply mr-5 no-underline hover:underline;
}

.tab-4-item:hover {
	@apply text-white;
}

.tab-4-item h2 {
	@apply text-gray-100 font-bold text-sm inline-block;
}

.tab-4-item span {
	@apply text-gray-500 font-normal text-sm mx-1.5;
}

.tweet-avatar img {
	@apply w-12 rounded-full;
}

.tweet-user-details a {
	@apply no-underline text-gray-100 font-bold text-base;
}

.tweet-user-details span {
	@apply no-underline text-gray-500 font-normal text-sm;
}

.tweet-content p {
	@apply text-gray-100 font-semibold text-sm;
}

.tweet-content-tab span {
	@apply text-gray-500 font-normal text-xs ml-1;
}

@media (min-width: 1205px) and (max-width: 1300px) {
	.header-user-img img {
		@apply p-2 rounded-full;
	}

	.header-user-img img:hover {
		@apply bg-gray-700;
	}
}

@media (min-width: 501px) and (max-width: 1204px) {
	.header-user-img img {
		@apply p-2 rounded-full;
	}

	.header-user-img img:hover {
		@apply bg-gray-700;
	}

	section {
		@apply max-w-xl;
	}

	.user-tab-3 {
		@apply flex-wrap;
	}
}

@media (max-width: 500px) {
	.user-tab-3 {
		@apply flex-wrap;
	}

	section {
		@apply m-0;
	}

	.cta-4 button {
		@apply p-2 text-sm;
	}
}
</style>
