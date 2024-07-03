<script setup>
import NavLink from "../Layouts/NavLink.vue";
import { onMounted, reactive, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import TweetModal from "@/Components/TweetModal.vue";

const page = usePage();

const authStore = useAuthStore();

const {user} = storeToRefs(authStore);

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
});

const getComponent = (page) => {
  let component = page.component;

  component = component.split("/");

  const index = component.length - 1;

  component = component[index];

  return component;
};

// Function to update active status based on the current page component
const updateActiveLinks = () => {
  const component = getComponent(page);
  for (const key in links) {
    if (Object.hasOwn(links, key)) {
      const link = links[key];
      if (link.label === "Profile") {
        link.active = page.url.startsWith(
            `/profile/${user.value.username}`,
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
  <aside
      class="p-10 pr-[3.6rem] h-screen flex flex-col items-start gap-8 thinBorder-r sticky top-0">
    <NavLink :href="route('Home')" class="flex items-center">
      <i class="fa-brands fa-twitter fa-lg mb-2 text-sky-400"/>
      <p class="-mt-1.5">TwitterClone</p>
    </NavLink>

    <NavLink
        :class="{
				active: links.home.active,
				navLink: !links.home.active,
			}"
        :href="links.home.href">
      <i :class="links.home.icon"/>
      {{ links.home.label }}
    </NavLink>

    <NavLink
        :class="{
				active: links.notifications.active,
				navLink: !links.notifications.active,
			}"
        :href="links.notifications.href">
      <div class="relative inline-block">
        <i :class="links.notifications.icon"/>

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
      {{ links.notifications.label }}
    </NavLink>

    <NavLink
        :class="{
				active: links.profile.active,
				navLink: !links.profile.active,
			}"
        :href="links.profile.href">
      <i :class="links.profile.icon"/>
      {{ links.profile.label }}
    </NavLink>

    <Link
        :href="route('logout')"
        as="button"
        class="navLink text-white text-xl font-bold text-capitalize flex items-center gap-4"
        method="post">
      <i class="fa-solid fa-arrow-right-from-bracket"/>
      Logout
    </Link>
    <TweetModal/>
    <div
        class="flex items-center mt-12 space-x-4 absolute bottom-8 w-fit ml-[-1rem]">
      <Link :href="route('profile.index', user.username)">
        <img
            :alt="user.full_name"
            :src="user.profile_picture"
            class="w-12 aspect-square rounded-full bg-gray-500"/>
      </Link>
      <div class="space-y-1">
        <Link :href="route('profile.index', user.username)">
          <h2 class="font-semibold text-sm" v-text="user.full_name"/>
        </Link>
        <Link :href="route('profile.index', user.username)">
          <h3
              class="font-semibold text-gray-400 text-sm"
              v-text="`@${user.username}`"/>
        </Link>

        <span class="flex items-center space-x-1">
					<Link
              :href="route('profile.index', user.username)"
              class="text-xs hover:underline text-gray-600"
              rel="noopener noreferrer"
              v-text="'View profile'"/>
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
