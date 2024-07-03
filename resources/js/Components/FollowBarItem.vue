<script setup>
import { router } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { ref } from "vue";

defineProps({ user: Object });

const authStore = useAuthStore();

const status = ref(false);

/**
 * The `addFollow` function is a method that sends a POST request using the
 * `router.post` method to create a new follow.
 *
 * @param {number} id - The user who's been followed
 */
const addFollow = (id) => {
	const data = {
		follower_id: authStore.user.id,
		followed_user_id: id,
	};

	router.post(route("follower.store"), data, {
		preserveScroll: true,
		onSuccess: () => {
			status.value = !status.value;
		},
	});
};
</script>

<template>
	<div class="followerGrid">
		<img
			:alt="user.username"
			:src="user.profile_picture"
			class="w-9 aspect-square rounded-md bg-gray-500" />
		<div class="flex flex-col ml-2">
			<Link
				:href="route('profile.index', user.username)"
				class="font-semibold text-sm text-gray-200 hover:underline transition cursor-pointer"
				v-text="user.full_name" />
			<Link
				:href="route('profile.index', user.username)"
				class="font-semibold text-sm text-gray-400 transition cursor-pointer -mt-1"
				v-text="`@${user.username}`" />
		</div>
		<div class="FollowBtn w-full">
			<button
				v-if="!status"
				class="bg-gray-100 rounded-3xl px-6 py-1.5 grid items-center font-extrabold text-sm text-black w-fit h-fit border"
				@click="addFollow(user.id)">
				Follow
			</button>
			<button
				v-if="status"
				class="bg-black rounded-3xl px-4 py-1.5 grid items-center font-extrabold text-sm text-gray-100 w-fit h-fit border"
				@click="addFollow(user.id)">
				Following
			</button>
		</div>
	</div>
</template>

<style scoped>
.followerGrid {
	display: grid;
	grid-template-areas: "image full_name btn";
	grid-template-columns: auto auto 1fr;
	place-items: center;
}

.FollowBtn {
	grid-area: btn;
	display: flex;
	justify-content: flex-end;
}
</style>
