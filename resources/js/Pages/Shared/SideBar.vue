<template>
	<aside class="p-10 w-fit h-screen flex flex-col items-start gap-8 relative">
		<NavLink href="/">
			<i class="fa-brands fa-twitter fa-lg mb-2"></i>
		</NavLink>

		<NavLink href="/">
			<i class="fa-solid fa-house"></i>
			Home
		</NavLink>
		<NavLink href="/notifications">
			<i class="fa-solid fa-bell"></i>
			Notifications
		</NavLink>
		<NavLink href="/profile">
			<i class="fa-solid fa-user"></i>
			Profile
		</NavLink>
		<NavLink as="button" href="/user/logout" method="post">
			<i class="fa-solid fa-arrow-right-from-bracket"></i>
			Logout
		</NavLink>
		<NavLink
			as="button"
			href="user/post"
			class="bg-sky-500 px-5 py-3 rounded-xl">
			<i class="fa-solid fa-feather"></i>
			Tweet
		</NavLink>
		<div class="flex items-center p-2 mt-12 space-x-4 absolute bottom-8 w-full">
			<Link :href="`/profile/${user.username}`">
				<img
					:src="
						user.profile_picture ||
						'https://source.unsplash.com/100x100/?portrait'
					"
					:alt="user.fullname"
					class="w-14 h-14 rounded-full bg-gray-500" />
			</Link>
			<div class="space-y-1">
				<Link :href="`/profile/${user.username}`">
					<h2
						class="text-lg font-semibold"
						v-text="user.fullname"></h2>
				</Link>
				<Link :href="`/profile/${user.username}`">
					<h3
						class="font-semibold text-gray-400"
						v-text="`@${user.username}`"></h3>
				</Link>

				<span class="flex items-center space-x-1">
					<Link
						rel="noopener noreferrer"
						:href="`/profile/${user.username}`"
						class="text-xs hover:underline text-gray-600"
						>View profile</Link
					>
				</span>
			</div>
		</div>
	</aside>
</template>
<script setup>
import NavLink from "./NavLink.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.auth.user);
</script>
