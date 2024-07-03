<script setup>
import { useGlobalState } from "@/stores/globalDataStore.js";

defineProps({ option: String });

const globalState = useGlobalState();
</script>

<template>
	<div
		class="flex justify-center flex-1 p-3 hover:bg-gray-950 transition duration-300 cursor-pointer relative thinBorder-r"
		@click="globalState.setActiveNotificationOption(option)">
		{{ option }}
		<div
			v-if="option === globalState.activeNotificationOption.value"
			class="absolute bottom-0 w-10 h-1 rounded-full bg-sky-400" />
	</div>
</template>
