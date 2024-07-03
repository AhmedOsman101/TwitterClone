<script setup>
import Option from "@/Components/Option.vue";

const props = defineProps({ options: Array });
</script>

<template>
	<!-- Header -->
	<div class="flex w-full thinBorder-b">
		<Option v-for="option of options" :key="option" :option="option" />
	</div>
</template>
