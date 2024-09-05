<script lang="ts" setup>
	import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
	import AxiosInstance from "@/Axios";
	import Header from "@/Components/Header.vue";
	import Notification from "@/Components/Notification.vue";
	import NoNotifications from "@/Components/Placeholders/NoNotifications.vue";
	import OptionsBar from "@/Components/OptionsBar.vue";
	import { Head } from "@inertiajs/vue3";
	import { onMounted, Reactive, reactive, toRaw } from "vue";
	import { useGlobalState } from "@/stores/globalDataStore.js";
	import { GlobalDataStore, INotifications } from "@/types";
	import { NotificationOptions } from "@/types/Enums";
	import { useAxios } from "@vueuse/integrations/useAxios";
	import { isEmptyArray } from "@/lib/Helpers";

	defineOptions({ layout: AuthenticatedLayout });

	const notifications: INotifications = reactive({} as INotifications);

	const fetchNotifications = async () => {
		const { data } = await useAxios(
			route("auth.user.notifications"),
			AxiosInstance
		);

		let temp = toRaw(data).value;

		notifications.all = temp.all;
		notifications.read = temp.read;
		notifications.unread = temp.unread;

		console.log("I Ran");
	};

	const updateNotification = async () => {
		await fetchNotifications();
	};

	onMounted(async () => {
		await fetchNotifications();
	});

	const globalState: GlobalDataStore = useGlobalState();
</script>

<template>
	<Head title="Notifications" />
	<Header
		backable
		class="Header" />

	<section
		class="min-h-fit"
		@updateNotifications="() => console.log('I Ran')">
		<OptionsBar
			:options="['all', 'read', 'unread']"
			type="notification" />
		<div
			v-show="
				!isEmptyArray(notifications.all) &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.All
			"
			v-for="notification in notifications.all"
			:key="notification.id">
			<Notification :notification="notification" />
		</div>

		<div
			v-for="notification in notifications?.read"
			v-show="
				notifications?.read?.length !== 0 &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.Read
			"
			:key="notification.id">
			<Notification :notification="notification" />
		</div>

		<div
			v-for="notification in notifications?.unread"
			v-show="
				notifications?.unread?.length !== 0 &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.Unread
			"
			:key="notification.id">
			<Notification :notification="notification" />
		</div>

		<NoNotifications
			v-show="
				isEmptyArray(notifications.all) &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.All
			"
			class="mt-16" />
		<NoNotifications
			v-show="
				isEmptyArray(notifications.read) &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.Read
			"
			class="mt-16" />
		<NoNotifications
			v-show="
				isEmptyArray(notifications.unread) &&
				globalState.activeNotificationOption.value ===
					NotificationOptions.Unread
			"
			class="mt-16" />
	</section>
</template>
