<script lang="ts" setup>
	import { useAuthStore } from "@/stores/authStore";
	import { usePage } from "@inertiajs/vue3";
	import SideBar from "../Components/SideBar.vue";
	import FollowBar from "@/Components/FollowBar.vue";
	import { User } from "@/types";

	const page = usePage();

	const authStore = useAuthStore();

	authStore.setAuthenticatedUser(page.props.auth.user as unknown as User);
</script>

<template>
	<section id="Home">
		<SideBar />
		<slot />
		<FollowBar />
	</section>
</template>

<style scoped>
	section {
		grid-template-areas:
			"nav header followBar"
			"nav tweet followBar"
			"nav feed followBar";

		display: grid;
		/* grid-template-columns: auto 1fr 24rem; */
		grid-template-rows: auto auto 1fr;

		@apply lg:grid-cols-[auto_1fr_24rem]
    grid-cols-[auto_1fr_20rem];
	}
</style>
