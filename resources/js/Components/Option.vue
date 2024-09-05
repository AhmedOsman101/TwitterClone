<script lang="ts" setup>
	import { NotificationOptions, ProfileOptions } from "@/types/Enums";
	import { useGlobalState } from "@/stores/globalDataStore.js";
	import { computed } from "vue";

	const props = defineProps<{
		option: string;
		type: string;
	}>();

	const GlobalState = useGlobalState();

	const activeOption = computed(() => {
		if (props.type === "notification") {
			return GlobalState.activeNotificationOption;
		} else {
			return GlobalState.activeProfileOption;
		}
	});

	const handleClick = () => {
		if (props.type === "notification") {
			GlobalState.setActiveNotificationOption(
				props.option as NotificationOptions
			);
		} else {
			GlobalState.setActiveProfileOption(props.option as ProfileOptions);
		}
	};
</script>

<template>
	<div
		class="flex justify-center flex-1 p-3 hover:bg-gray-950 transition duration-300 cursor-pointer relative thinBorder-r"
		@click="handleClick">
		{{ option }}
		<div
			v-if="option === activeOption.value"
			class="absolute bottom-0 w-10 h-1 rounded-full bg-sky-400" />
	</div>
</template>
