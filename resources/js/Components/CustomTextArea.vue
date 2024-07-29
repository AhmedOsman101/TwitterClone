<script lang="ts" setup>
	import { computed, onMounted, ref, watch } from "vue";
	import { usePage } from "@inertiajs/vue3";
	import { useAuthStore } from "@/stores/authStore.js";
	import { storeToRefs } from "pinia";
	import InputError from "./InputError.vue";
	import EmojiPicker, { EmojiExt } from "vue3-emoji-picker";
	import { set } from "@vueuse/core";

	//events
	const emit = defineEmits(["closeModal"]);

	//props

	const props = withDefaults(
		defineProps<{
			action: Function;
			maxLength: number;
			placeHolder?: string;
			Label?: string;
		}>(),
		{ placeHolder: "What is happening?!" }
	);

	// hooks
	const page = usePage();
	const authStore = useAuthStore();

	// refs & variables
	const { user } = storeToRefs(authStore);
	const input = ref(null as any);
	const body = ref("");
	const showEmojiPicker = ref(false);
	const progress = ref("");

	onMounted(() => {
		input.value.focus();
	});

	// computed properties
	const errors = computed(() => page.props.errors);

	// methods
	const create = (data: string) => {
		set(body, "");

		props.action(data);

		emit("closeModal");

		input.value.style.height = `auto`;
	};

	const autoResize = (element: HTMLTextAreaElement) => {
		// Reset the height to auto to calculate the new scroll height
		element.style.height = "auto";

		const scHeight = element.scrollHeight;

		// Update state
		body.value = element.value;

		// Update styles
		element.style.height = `${scHeight}px`;
	};

	const showProgress = (maxLength: number, element: HTMLTextAreaElement) => {
		const progressPercentage =
			((maxLength - element.value.length) / maxLength) * 100;

		const progressElements: NodeListOf<HTMLDivElement> =
			document.querySelectorAll(".progress");

		progress.value = `${progressPercentage.toFixed(2)}%`;

		if (progressElements.length < 2) {
			progressElements[0].style.background = `conic-gradient(#0ea5e9 ${progress.value}, #2f3336 0%)`;
		} else {
			progressElements[1].style.background = `conic-gradient(#0ea5e9 ${progress.value}, #2f3336 0%)`;
		}
	};

	const toggleEmojiPicker = () => {
		showEmojiPicker.value = !showEmojiPicker.value;
	};

	const addEmoji = (emoji: EmojiExt) => {
		body.value += emoji.i;
	};

	watch(body, () => showProgress(props.maxLength, input.value));
</script>

<template>
	<section
		id="Tweet"
		class="flex flex-col w-full h-fit max-h-dvh pt-4 thinBorder-b"
		@click="
			() => {
				if (showEmojiPicker) showEmojiPicker = false;
			}
		">
		<div class="flex place-items-center px-5">
			<div class="rounded-full h-fit mr-4">
				<img
					:src="user.profile_picture"
					alt="profile"
					class="max-h-full max-w-full w-12 aspect-square rounded-full" />
			</div>
			<textarea
				ref="input"
				v-model="body"
				:maxlength="maxLength"
				:placeholder="placeHolder"
				class="block dark:bg-black text-xl w-full p-4 px-0 disabled:opacity-80 resize-none ring-0 dark:placeholder-neutral-500 dark:text-white"
				cols="40"
				required
				rows="1"
				type="text"
				wrap="hard"
				@input="autoResize(input)">
			</textarea>
		</div>
		<div
			class="flex justify-end p-5 place-items-center space-x-5 w-full relative">
			<div class="grid place-items-center absolute left-10">
				<button @click.stop="toggleEmojiPicker">
					<svg
						class="stroke-sky-400"
						fill="none"
						height="24"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						width="24"
						xmlns="http://www.w3.org/2000/svg">
						<circle
							cx="12"
							cy="12"
							r="10" />
						<path d="M8 14s1.5 2 4 2 4-2 4-2" />
						<line
							x1="9"
							x2="9"
							y1="9"
							y2="9" />
						<line
							x1="15"
							x2="15"
							y1="9"
							y2="9" />
					</svg>
				</button>
				<EmojiPicker
					v-if="showEmojiPicker"
					:native="true"
					:theme="'dark'"
					class="border absolute top-8 left-0 z-50"
					@select="addEmoji"
					@click.stop />
			</div>
			<InputError :message="errors.body" />
			<div
				v-show="body.length"
				:data-value="maxLength - body.length"
				class="progress border" />
			<button
				:disabled="!body.length"
				class="bg-sky-500 px-5 py-2 rounded-3xl opacity-100 text-white font-semibold disabled:opacity-80"
				@click="() => create(body)"
				v-text="Label ?? 'Tweet'" />
		</div>
	</section>
</template>

<style>
	#Tweet {
		grid-area: tweet;
	}

	#Tweet textarea:focus,
	#Tweet textarea:active {
		outline: none !important;
		border: none;
	}

	#Tweet textarea {
		resize: none;
		scrollbar-width: none;
		width: 100%;
	}

	.progress {
		--size: 2.34375rem; /* Smaller size */
		--bar-width: 0.5625rem; /* Smaller bar width */
		--progress: 0%;
		width: var(--size);
		aspect-ratio: 1/1;
		background: conic-gradient(#0ea5e9 0%, #2f3336 0%);
		border-radius: 50%;
		display: grid;
		place-items: center;
	}

	.progress::after {
		content: attr(data-value);
		border-radius: 50%;
		background: black;
		width: calc(100% - var(--bar-width));
		aspect-ratio: 1/1;
		display: grid;
		place-items: center;
		color: whitesmoke;
		font-size: 0.7rem; /* Smaller font size */
		font-weight: bold;
	}
</style>
