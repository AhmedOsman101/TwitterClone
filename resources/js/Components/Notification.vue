<script lang="ts" setup>
	import { computed, ref } from "vue";
	import Tooltip from "@/Components/Tooltip.vue";
	import { router } from "@inertiajs/vue3";
	import axios from "axios";
	import { useAuthStore } from "@/stores/authStore.js";
	import { NotificationTypes } from "@/lib/Enums";
	import { INotification } from "@/lib/Interfaces";
	import { AuthStore } from "@/lib/Types";
	import { ParameterValue } from "../../../vendor/tightenco/ziggy/src/js";

	const props = defineProps<{
		notification: INotification;
	}>();

	const authStore: AuthStore = useAuthStore();

	const isTooltipOneOpen = ref(false);
	const isTooltipTwoOpen = ref(false);

	const notificationType = computed(() => props.notification.type);

	const formatMessage = (): Record<string, string> | undefined => {
		let input = props.notification.message;

		let startIndex = -1;

		if (notificationType.value === NotificationTypes.Follow) {
			startIndex = input.indexOf("started");

			const part1 = input.substring(0, startIndex);

			const part2 = input.substring(startIndex);

			return { part1, part2 };
		}

		if (notificationType.value === NotificationTypes.Like) {
			startIndex = input.indexOf("liked");

			let middleIndex = input.indexOf("your");

			const part1 = input.substring(0, startIndex);

			const part2 = input.substring(startIndex, middleIndex);

			const part3 = input.substring(middleIndex);

			return { part1, part2, part3 };
		}

		if (notificationType.value === NotificationTypes.Reply) {
			startIndex = input.indexOf("replied");

			let middleIndex = input.indexOf("your");

			const part1 = input.substring(0, startIndex);

			const part2 = input.substring(startIndex, middleIndex);

			const part3 = input.substring(middleIndex);

			return { part1, part2, part3 };
		}
	};

	const formattedMessage = computed(() => formatMessage());

	const showTooltip = (index: number) => {
		switch (index) {
			case 1:
				isTooltipOneOpen.value = true;
				break;
			case 2:
				isTooltipTwoOpen.value = true;
				break;
			default:
				isTooltipOneOpen.value = isTooltipTwoOpen.value = false;
				break;
		}
	};

	const hideTooltip = (index: number) => {
		switch (index) {
			case 1:
				isTooltipOneOpen.value = false;
				break;
			case 2:
				isTooltipTwoOpen.value = false;
				break;
			default:
				isTooltipOneOpen.value = isTooltipTwoOpen.value = false;
				break;
		}
	};

	const markAsRead = (id: string) => {
		router.put(
			route("notifications.update"),
			{ id },
			{
				onSuccess: () => {
					authStore.fetchUser();
				},
			}
		);
	};

	const dismiss = (id: string) => {
		axios
			.delete(route("notifications.destroy"), { data: { id } })
			.then(() => authStore.fetchUser());
	};
</script>

<template>
	<div
		:class="{
			'opacity-50': notification.read_at !== null,
		}"
		class="notification pl-5 pt-5 thinBorder-b">
		<Link
			:href="route('profile.index', notification.username)"
			class="w-fit h-fit rounded-full image cursor-pointer">
			<img
				:alt="notification.full_name"
				:src="notification.profile_picture"
				class="w-10 h-10 rounded-full bg-gray-500" />
		</Link>
		<div class="flex align-start gap-3 notificationHead">
			<Link
				:href="route('profile.index', notification.username)"
				class="font-semibold text-gray-200 hover:underline transition cursor-pointer h-fit"
				v-text="notification.full_name" />
			<span class="text-gray-400">•</span>
			<p
				class="font-semibold text-gray-400"
				v-text="notification.created_at" />
		</div>

		<p
			v-if="notificationType === NotificationTypes.Follow"
			class="notificationBody">
			<Link
				:href="route('profile.index', notification.username)"
				class="font-semibold hover:underline"
				v-text="formattedMessage?.part1" />
			<span v-text="formattedMessage?.part2" />
		</p>

		<p
			v-if="
				notificationType === NotificationTypes.Like ||
				notificationType === NotificationTypes.Reply
			"
			class="notificationBody">
			<Link
				:href="route('profile.index', notification.username)"
				class="font-semibold hover:underline"
				v-text="formattedMessage?.part1" />
			<span v-text="formattedMessage?.part2" />
			<Link
				:href="
					route('tweet.show', notification.tweet_id as ParameterValue)
				"
				class="hover:underline"
				v-text="formattedMessage?.part3" />
		</p>

		<div class="actions">
			<button
				class="action_button group"
				@click="dismiss(notification.id)"
				@mouseenter="showTooltip(2)"
				@mouseleave="hideTooltip(2)">
				<i class="fa-solid fa-xmark" />
				<Tooltip
					:message="'Dismiss'"
					:visible="isTooltipTwoOpen" />
			</button>

			<button
				v-show="notification.read_at === null"
				class="action_button group"
				@click="markAsRead(notification.id)"
				@mouseenter="showTooltip(1)"
				@mouseleave="hideTooltip(1)">
				<i class="fa-solid fa-check" />
				<Tooltip
					:message="'Mark as Read'"
					:visible="isTooltipOneOpen" />
			</button>
		</div>
	</div>
</template>

<style scoped>
	.notification {
		display: grid;
		grid-template-rows: repeat(2, auto);
		grid-template-columns: auto 4fr 1fr;
		gap: 0.8rem;
		grid-template-areas:
			"image header actions"
			"body body link";
		@apply min-h-fit h-fit pr-4;
	}

	.notificationHead {
		grid-area: header;
	}

	.notificationBody {
		grid-area: body;
		@apply text-lg pr-1 pb-8 whitespace-break-spaces;
	}

	.actions {
		grid-area: actions;
		@apply flex 
		flex-row-reverse 
		justify-between 
		items-center 
		h-full
		gap-3 
		w-full;
	}

	.action_button {
		@apply rounded-full 
		bg-black 
		hover:bg-gray-950 
		relative 
		aspect-square 
		h-full 
		thinBorder;
	}
</style>
