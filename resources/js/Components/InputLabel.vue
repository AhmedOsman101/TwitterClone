<script setup lang="ts">
	defineProps<{
		value?: string;
	}>();
</script>

<template>
	<label class="block font-semibold text-sm text-gray-600 dark:text-gray-200">
		<span v-if="value">{{ value }}</span>
		<span v-else><slot /></span>
	</label>
</template>
