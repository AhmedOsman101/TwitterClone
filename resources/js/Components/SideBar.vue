<script setup>
	import NavLink from "../Layouts/NavLink.vue";
	import { onMounted, reactive, watch } from "vue";
	import { usePage } from "@inertiajs/vue3";
	import { useAuthStore } from "@/stores/authStore.js";
	import { storeToRefs } from "pinia";
	import TweetModal from "@/Components/TweetModal.vue";
	import { getComponent } from "@/Helpers";

	const page = usePage();

	const authStore = useAuthStore();

	const { user } = storeToRefs(authStore);

	// Define links as a reactive object
	const links = reactive({
		home: {
			href: route("Home"),
			label: "Home",
			icon: "fa-solid fa-house",
			active: false,
		},
		notifications: {
			href: route("notifications"),
			label: "Notifications",
			icon: "fa-solid fa-bell",
			active: false,
		},
		profile: {
			href: route("profile.index", user.value.username),
			label: "Profile",
			icon: "fa-solid fa-user",
			active: false,
		},
		logout: {
			href: route("logout"),
			label: "Logout",
			icon: "fa-solid fa-arrow-right-from-bracket",
			active: false,
		},
	});

	// Function to update active status based on the current page component
	const updateActiveLinks = () => {
		const component = getComponent(page);
		for (const key in links) {
			if (Object.hasOwn(links, key)) {
				const link = links[key];
				if (link.label === "Profile") {
					link.active = page.url.startsWith(
						`/profile/${user.value.username}`
					);
				} else {
					link.active = component === link.label;
				}
			}
		}
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
	<aside>
		<div class="Top">
			<NavLink
				:href="route('Home')"
				class="flex items-center">
				<i class="fa-brands fa-twitter text-sky-400 logo" />
				<p class="text-2xl hidden lg:block">TwitterClone</p>
			</NavLink>
			<NavLink
				:class="{
					active: links.home.active,
					navLink: !links.home.active,
				}"
				:href="links.home.href">
				<i :class="links.home.icon" />
				<span class="lg:block hidden">{{ links.home.label }}</span>
			</NavLink>
			<NavLink
				:class="{
					active: links.notifications.active,
					navLink: !links.notifications.active,
				}"
				:href="links.notifications.href">
				<div class="relative inline-block">
					<i :class="links.notifications.icon" />
					<div
						v-show="user.notifications.unread.length !== 0"
						:class="{
							'absolute -top-1.5 -right-3 flex h-4 w-6 aspect-square items-center justify-center rounded-full bg-red-500 text-xs text-white':
								user.notifications.unread.length >= 100,
							'absolute -top-1.5 -right-1 flex h-4 w-4 aspect-square items-center justify-center rounded-full bg-red-500 text-xs text-white':
								user.notifications.unread.length < 100,
						}">
						{{
							user.notifications.unread.length < 100
								? user.notifications.unread.length
								: "99+"
						}}
					</div>
				</div>
				<span class="lg:block hidden">{{
					links.notifications.label
				}}</span>
			</NavLink>
			<NavLink
				:class="{
					active: links.profile.active,
					navLink: !links.profile.active,
				}"
				:href="links.profile.href">
				<i :class="links.profile.icon" />
				<span class="lg:block hidden">{{ links.profile.label }}</span>
			</NavLink>
			<NavLink
				:href="route('logout')"
				as="button"
				:class="{
					active: links.logout.active,
					navLink: !links.logout.active,
				}"
				method="post">
				<i :class="links.logout.icon" />
				<span class="lg:block hidden">Logout</span>
			</NavLink>
		</div>

		<div class="Bottom">
			<TweetModal />
			<div
				class="flex items-center lg:px-3 space-x-2 w-full rounded-3xl hover:bg-[#181818] cursor-pointer">
				<Link :href="route('profile.index', user.username)">
					<img
						:alt="user.full_name"
						:src="user.profile_picture"
						class="w-11 aspect-square rounded-full bg-gray-500" />
				</Link>
				<Link
					:href="route('profile.index', user.username)"
					class="hidden lg:block py-1">
					<h2>
						<h3
							class="font-semibold lg:text-base"
							v-text="user.full_name" />
					</h2>
					<h2>
						<h3
							class="font-semibold text-gray-400 lg:text-base"
							v-text="`@${user.username}`" />
					</h2>
				</Link>
			</div>
		</div>
	</aside>
</template>

<style scoped>
	aside {
		grid-area: nav;
		grid-template-areas:
			"top"
			"bottom";

		grid-template-rows: auto 1fr;
		@apply top-0
    thinBorder-r
    h-dvh
    grid
    place-items-center
    sticky
    px-5
    lg:pb-2;
	}

	.Top,
	.Bottom {
		@apply flex
    flex-col
    gap-4
    items-center
    lg:items-start;
	}

	.Top {
		grid-area: top;
		@apply pt-4
    lg:gap-6 
    lg:pt-10
    lg:pr-12
    lg:pl-5;
	}

	.Bottom {
		grid-area: bottom;
		place-content: end;
		@apply h-full lg:gap-5 w-full;
	}

	aside i:not(.logo) {
		@apply text-lg
    lg:text-xl;
	}

	.logo {
		@apply text-2xl
    lg:text-3xl;
	}

	.active {
		@apply transition  
    duration-400 
    ease-in-out
    text-sky-500 
    hover:text-sky-300;
	}

	.navLink {
		@apply text-white 
    transition 
    duration-400 
    ease-in-out
    hover:text-sky-500;
	}

	.logout {
		@apply transition 
    text-white
    duration-400 
    ease-in-out 
    text-lg
    font-bold 
    capitalize 
    flex 
    items-center 
    py-3
    aspect-square
    rounded-full 
    /* bg-sky-500  */
    hover:text-sky-500
    lg:gap-4
    lg:aspect-auto
    lg:px-7
    /* lg:-ml-4 */
    lg:text-xl;
	}
</style>
