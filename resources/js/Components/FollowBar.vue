<script lang="ts" setup>
	import FollowBarItem from "@/Components/FollowBarItem.vue";
	import { onMounted, ref } from "vue";
	import axios from "axios";
	import { useAuthStore } from "@/stores/authStore.js";
	import NoSuggestions from "@/Components/Placeholders/NoSuggestions.vue";

	const users = ref([]);

	const authStore = useAuthStore();

	onMounted(() => {
		axios
			.get(route("follower.suggest", authStore.user.id))
			.then((res) => (users.value = res.data));
	});
</script>

<template>
	<div class="FollowBarContainer">
		<div class="FollowBar">
			<h3 class="text-lg font-semibold mb-3">Who to Follow</h3>
			<div class="space-y-5">
				<FollowBarItem
					v-if="users.length > 0"
					v-for="user in users"
					:key="user.id"
					:user="user" />

				<NoSuggestions v-else />
			</div>
		</div>
	</div>
</template>

<style scoped>
	.FollowBarContainer {
		grid-area: followBar;
		@apply min-h-dvh 
		h-dvh 
		w-full 
		thinBorder-l 
		lg:px-7
		p-7
		px-5
		sticky 
		top-0;
	}
	.FollowBar {
		@apply rounded-2xl 
		thinBorder 
		py-4 
		px-5;
	}
</style>
