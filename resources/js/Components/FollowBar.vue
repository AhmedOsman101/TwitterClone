<script lang="ts" setup>
	import FollowBarItem from "@/Components/FollowBarItem.vue";
	import { ref } from "vue";
	import NoSuggestions from "@/Components/Placeholders/NoSuggestions.vue";
	import { useAxios } from "@vueuse/integrations/useAxios";
	import AxiosInstance from "@/Axios";
	import { IShortUser } from "@/types";
	import { isEmptyArray } from "@/lib/Helpers";

	const { data, isLoading } = useAxios(
		route("follower.suggest"),
		AxiosInstance
	);

	const users = ref(data as unknown as IShortUser[]);
</script>

<template>
	<div class="FollowBarContainer">
		<div class="FollowBar">
			<h3 class="text-lg font-semibold mb-3">Who to Follow</h3>
			<div class="space-y-5">
				<FollowBarItem
					v-if="!isEmptyArray(users)"
					v-for="user in users"
					:key="user.id"
					:user="user" />

				<NoSuggestions v-if="isEmptyArray(users) || isLoading" />
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
