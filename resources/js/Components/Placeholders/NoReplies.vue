<script setup>
	defineProps({ full_name: String });
</script>

<template>
	<div class="flex items-center justify-center w-full rounded-lg">
		<div class="flex flex-col items-center">
			<div
				class="flex items-center justify-center w-10 h-10 mb-4 bg-[#2a2a2a] rounded-full">
				<svg
					class="w-4 h-4 text-[#6e6e6e]"
					fill="none"
					height="24"
					stroke="currentColor"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					viewBox="0 0 24 24"
					width="24"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M18 6 6 18" />
					<path d="m6 6 12 12" />
				</svg>
			</div>
			<p class="text-gray-500">
				{{ $props.full_name }} has not replied to any tweets yet
			</p>
		</div>
	</div>
</template>
