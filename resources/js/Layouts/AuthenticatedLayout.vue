<script setup>
import { useAuthStore } from "@/stores/authStore";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import SideBar from "../Components/SideBar.vue";
import FollowBar from "@/Components/FollowBar.vue";

const page = usePage();

const authStore = useAuthStore();
onMounted(() => {
  authStore.setAuthenticatedUser(page.props.auth.user);
});
</script>

<template>
  <section id="Home">
    <SideBar :user="authStore.user"/>
    <slot/>
    <FollowBar/>
  </section>
</template>

<style scoped>
section {
  grid-template-areas:
        "nav header followBar"
        "nav tweet followBar"
        "nav feed followBar";

  display: grid;
  grid-template-columns: 20rem 1fr 23rem;
  grid-template-rows: auto auto 1fr;
}
</style>
