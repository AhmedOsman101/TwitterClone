<script lang="ts" setup>
  import FollowBar from "@/Components/FollowBar.vue";
  import { useAuthStore } from "@/stores/authStore";
  import { User } from "@/types";
  import { usePage } from "@inertiajs/vue3";
  import SideBar from "../Components/SideBar.vue";

  interface PageProps {
    user: User;
    [key: string]: any;
  }

  const page = usePage<PageProps>();

  const authStore = useAuthStore();

  authStore.setAuthenticatedUser(page.props.auth.user);

  authStore.fetchUser();
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
