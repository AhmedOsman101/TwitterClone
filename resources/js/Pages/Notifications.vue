<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Notification from "@/Components/Notification.vue";
import { useAuthStore } from "@/stores/authStore.js";
import { computed } from "vue";
import NoNotifications from "@/Components/NoNotifications.vue";

defineOptions({layout: AuthenticatedLayout});

const authStore = useAuthStore();

const notifications = computed(() => authStore.user.notifications);

</script>

<template>

  <Head title="Notifications"/>
  <Header :backable="true" class="Header"/>

  <div v-for="notification in notifications" v-if="notifications.length !== 0" :key="notification.id">

    <Notification :notification="notification"/>
  </div>

  <NoNotifications v-else class="mt-16"/>

</template>

<style scoped>

</style>