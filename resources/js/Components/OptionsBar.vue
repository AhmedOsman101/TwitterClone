<script lang="ts" setup>
	import Option from "@/Components/Option.vue";

	const props = defineProps<{
		options: Array<string>;
		type: string;
	}>();
</script>

<template>
	<!-- Header -->
	<div class="flex w-full thinBorder-b">
		<Option
			v-for="option of options"
			:key="option"
			:option="option"
			:type="type" />
	</div>
</template>
