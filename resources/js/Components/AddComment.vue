<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import { useCommentStore } from "@/stores/commentStore.js";
import InputError from "./InputError.vue";
import EmojiPicker from "vue3-emoji-picker";

// hooks
const page = usePage();
const authStore = useAuthStore();
const commentStore = useCommentStore();

// refs & variables
const maxCommentLength = 255;
const input = ref(null);
const body = ref("");
const { user } = storeToRefs(authStore);
const showEmojiPicker = ref(false);

// computed properties
const errors = computed(() => page.props.errors);

onMounted(() => {
	input.value.focus();
});

// methods



/**
 * The `autoResize` function is responsible for automatically resizing the textarea element
 *  as the user types in text.
 */
const autoResize = () => {
	let element = input.value;

	// Reset the height to auto to calculate the new scroll height
	element.style.height = "auto";
	let scHeight = element.scrollHeight;

	// Update state
	body.value = element.value;

	// Update styles
	element.style.height = `${scHeight}px`;
};

/**
 * The `showProgress` function is responsible for updating the visual progress
 * indicator displayed to the user as they type in the textarea.
 */
const showProgress = (maxlength, element) => {
	const progressElement = document.querySelector(".progress");

	const progressPercentage =
		((maxlength - element.value.length) / maxlength) * 100;
	const progress = `${progressPercentage.toFixed(2)}%`;
	progressElement.style.setProperty("--progress", progress);
};

watch(body, () => showProgress(maxCommentLength, input.value));

/**
 * The `toggleEmojiPicker` function is toggling the value of the
 * `showEmojiPicker` ref variable between `true` and `false`.
 */
const toggleEmojiPicker = () => {
	showEmojiPicker.value = !showEmojiPicker.value;
};

/**
 * The `addEmoji` function is a callback function that takes an `emoji` object as a parameter.
 *
 * Inside the function, it appends the `i` property of the `emoji` object to the
 * `body.value`, which represents the text content of the textarea where the
 * user is typing a comment.
 * @param {object} emoji
 */
const addEmoji = (emoji) => {
	body.value += emoji.i;
	console.log(body.value, body.value.length);
};
</script>

<template>
	<section
		id="Tweet"
		class="flex flex-col w-full h-fit relative"
		@click="
			() => {
				if (showEmojiPicker) showEmojiPicker = false;
			}
		">
		<div class="flex place-items-center px-5 pt-2.5 mb-3">
			<div class="rounded-full h-fit mr-4">
				<Link :href="route('profile.index', user.username)">
					<img
						:src="user.profile_picture"
						alt="profile"
						class="max-h-full max-w-full w-12 aspect-square rounded-full" />
				</Link>
			</div>
			<textarea
				ref="input"
				v-model="body"
				:maxlength="maxCommentLength"
				class="block dark:bg-black text-xl w-full pt-4 disabled:opacity-80 resize-none dark:placeholder-neutral-500 dark:text-white"
				cols="40"
				placeholder="Post your reply"
				required
				rows="1"
				type="text"
				wrap="hard"
				@input="autoResize">
			</textarea>
		</div>
		<div
			class="flex justify-end px-5 pb-5 place-items-center space-x-5 thinBorder-b">
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
						<circle cx="12" cy="12" r="10" />
						<path d="M8 14s1.5 2 4 2 4-2 4-2" />
						<line x1="9" x2="9" y1="9" y2="9" />
						<line x1="15" x2="15" y1="9" y2="9" />
					</svg>
				</button>
				<EmojiPicker
					v-if="showEmojiPicker"
					:native="true"
					:theme="'dark'"
					class="border absolute top-8 left-0"
					@select="addEmoji"
					@click.stop />
			</div>
			<InputError :message="errors.body" />
			<div
				v-show="body.length"
				:data-value="maxCommentLength - body.length"
				class="progress border" />
			<button
				:disabled="!body.length"
				class="bg-sky-500 px-5 py-2 rounded-3xl opacity-100 text-white font-semibold disabled:opacity-80"
				@click="
					() =>
						createComment(
							user.id,
							$page.props.tweet[0].id,
							$page.props.tweet[0].user_id,
						)
				">
				Reply
			</button>
		</div>
	</section>
</template>

<style scoped>
section {
	grid-area: tweet;
}

textarea:focus,
textarea:active {
	outline: none !important;
	border: none;
}

textarea {
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
	background: conic-gradient(#0ea5e9 var(--progress), #2f3336 0%);
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
