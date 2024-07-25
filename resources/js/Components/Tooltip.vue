<script lang="ts" setup>
	const props = defineProps<{
		message: string;
		visible: boolean;
	}>();
</script>
<template>
	<div
		v-show="$props.visible"
		:class="{
			'opacity-100': $props.visible,
			'opacity-0': !$props.visible,
		}"
		class="transition duration-500 ease-in-out bg-white text-black absolute top-full left-1/2 z-20 mt-1.5 -translate-x-1/2 whitespace-nowrap rounded-md py-1.5 px-2 text-sm ">
		<span
			class="absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45" />
		{{ $props.message }}
	</div>
</template>
