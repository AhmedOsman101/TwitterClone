<script setup>
import NavLink from "../Layouts/NavLink.vue";
import { onMounted, reactive, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";

const page = usePage();

const authStore = useAuthStore();

const { user } = storeToRefs(authStore);

const links = reactive([
	{
		href: route("Home"),
		label: "Home",
		icon: "fa-solid fa-house",
		active: false,
	},
	{
		href: "/notifications",
		label: "Notifications",
		icon: "fa-solid fa-bell",
		active: false,
	},
	{
		href: route("profile.index", user.value.username),
		label: "Profile",
		icon: "fa-solid fa-user",
		active: false,
	},
]);

const getComponent = (page) => {
	let component = page.component;

	component = component.split("/");

	const index = component.length - 1;

	component = component[index];

	return component;
};

// Function to update active status based on the current page component
const updateActiveLinks = () => {
	links.forEach((link) => {
		const component = getComponent(page);
		link.active = component === link.label;
	});
};

// Call the function initially to set the active link
onMounted(() => {
	updateActiveLinks();
	authStore.setAuthenticatedUser(page.props.auth.user);
});

// Watch for changes in the page component and update active links
watch(() => page.component, updateActiveLinks);
</script>

<template>
	<aside
		class="p-10 pr-20 w-full h-screen flex flex-col items-start gap-8 thinBorder-r sticky top-0">
		<NavLink :href="route('Home')" class="flex items-center">
			<i class="fa-brands fa-twitter fa-lg mb-2 text-sky-400" />
			<p class="-mt-1.5">Twitter</p>
		</NavLink>
		<div v-for="link in links" :key="link.label">
			<NavLink
				:class="{
					active: link.active,
					navLink: !link.active,
				}"
				:href="link.href">
				<i :class="link.icon" />
				{{ link.label }}
			</NavLink>
		</div>
		<Link
			:href="route('logout')"
			as="button"
			class="navLink text-white text-xl font-bold text-capitalize flex items-center gap-4"
			method="post">
			<i class="fa-solid fa-arrow-right-from-bracket" />
			Logout
		</Link>
		<NavLink
			as="button"
			class="bg-sky-500 px-5 py-3 rounded-3xl w-full flex justify-center ml-[-1rem]"
			href="user/post">
			<i class="fa-solid fa-feather" />
			Tweet
		</NavLink>
		<div
			class="flex items-center p-2 mt-12 space-x-4 absolute bottom-8 w-full">
			<Link :href="route('profile.index', user.username)">
				<img
					:alt="user.full_name"
					:src="user.profile_picture"
					class="w-14 h-14 rounded-full bg-gray-500" />
			</Link>
			<div class="space-y-1">
				<Link :href="route('profile.index', user.username)">
					<h2 class="text-lg font-semibold" v-text="user.full_name" />
				</Link>
				<Link :href="route('profile.index', user.username)">
					<h3
						class="font-semibold text-gray-400"
						v-text="`@${user.username}`" />
				</Link>

				<span class="flex items-center space-x-1">
					<Link
						:href="route('profile.index', user.username)"
						class="text-xs hover:underline text-gray-600"
						rel="noopener noreferrer"
						v-text="'View profile'" />
				</span>
			</div>
		</div>
	</aside>
</template>

<style scoped>
aside {
	grid-area: nav;
}

.active {
	@apply text-sky-500 hover:text-sky-300 transition duration-[400ms] ease-in-out;
}

.navLink {
	@apply text-white hover:text-sky-500 transition duration-[400ms] ease-in-out;
}
</style>
