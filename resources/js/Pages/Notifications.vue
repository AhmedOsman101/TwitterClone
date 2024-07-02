<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Notification from "@/Components/Notification.vue";
import { useAuthStore } from "@/stores/authStore.js";

defineOptions({layout: AuthenticatedLayout});

const authStore = useAuthStore();
</script>

<template>

  <Head title="Notifications"/>
  <Header :backable="true" class="Header"/>

  <div v-for="notification in authStore.user.notifications" :key="notification.id">

    <Notification :notification="notification"/>
  </div>

</template>

<style scoped>

</style>