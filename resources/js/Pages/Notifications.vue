<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Notification from "@/Components/Notification.vue";
import { useAuthStore } from "@/stores/authStore.js";
import { computed, toRaw } from "vue";
import NoNotifications from "@/Components/Placeholders/NoNotifications.vue";
import OptionsBar from "@/Components/OptionsBar.vue";
import { useGlobalState } from "@/stores/globalDataStore.js";
import { storeToRefs } from "pinia";

defineOptions({layout: AuthenticatedLayout});

const authStore = useAuthStore();

const {user} = storeToRefs(authStore);

const notifications = computed(() => toRaw(user.value.notifications));

const globalState = useGlobalState();
</script>

<template>
  <Head title="Notifications"/>
  <Header backable class="Header"/>

  <section class="min-h-fit">
    <OptionsBar :options="['all', 'read', 'unread']" type="notification"/>
    <div
        v-for="notification in notifications.all"
        v-if="
				notifications.all.length !== 0 &&
				globalState.activeNotificationOption.value === 'all'
			"
        :key="notification.id">
      <Notification :notification="notification"/>
    </div>

    <div
        v-for="notification in notifications.read"
        v-if="
				notifications.read.length !== 0 &&
				globalState.activeNotificationOption.value === 'read'
			"
        :key="notification.id">
      <Notification :notification="notification"/>
    </div>

    <div
        v-for="notification in notifications.unread"
        v-if="
				notifications.unread.length !== 0 &&
				globalState.activeNotificationOption.value === 'unread'
			"
        :key="notification.id">
      <Notification :notification="notification"/>
    </div>

    <NoNotifications
        v-if="
				notifications.all.length === 0 &&
				globalState.activeNotificationOption.value === 'all'
			"
        class="mt-16"/>
    <NoNotifications
        v-if="
				notifications.read.length === 0 &&
				globalState.activeNotificationOption.value === 'read'
			"
        class="mt-16"/>
    <NoNotifications
        v-if="
				notifications.unread.length === 0 &&
				globalState.activeNotificationOption.value === 'unread'
			"
        class="mt-16"/>
  </section>
</template>
