<template>
	<section id="Tweet" class="flex flex-col w-full h-fit max-h-screen">
		<div class="flex place-items-center p-5 pt-0 mt-9 wrapper">
			<div class="rounded-full h-fit mr-4">
				<img
					:src="user.profile_picture"
					alt="profile"
					class="max-h-full max-w-full w-12 aspect-square rounded-full" />
			</div>
			<textarea
				ref="input"
				v-model="body"
				:maxlength="maxTweetLength"
				class="block bg-black text-xl w-full p-4 px-0 disabled:opacity-80 resize-none ring-0 placeholder-neutral-500 text-white"
				cols="40"
				placeholder="What is happening?!"
				required
				rows="1"
				type="text"
				wrap="hard"
				@input="autoResize">
			</textarea>
		</div>
		<div class="flex justify-end p-5 place-items-center space-x-5">
			<ErrorMessage :error="errors.body" />
			<div
				v-show="body.length"
				:data-value="maxTweetLength - body.length"
				class="progress border" />
			<button
				:disabled="!body.length"
				class="bg-sky-500 px-5 py-2 rounded-3xl opacity-100 text-white font-semibold disabled:opacity-80"
				@click="createTweet">
				Tweet
			</button>
		</div>
		<hr />
	</section>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import ErrorMessage from "@/src/Components/ErrorMessage.vue";

// refs & variables
const input = ref(null);
const body = ref("");
const maxTweetLength = 300;

// computed properties
const user = computed(() => page.props.auth.user);
const errors = computed(() => page.props.errors);

// hooks
const page = usePage();

onMounted(() => {
	input.value.focus();
});

// methods
const createTweet = () => {
	router.post("tweet", { user_id: user.value.id, body: body.value });
	if (!errors.value.body) body.value = "";
};

const autoResize = () => {
	const element = input.value;
	const progressElement = document.querySelector(".progress");

	let scHeight = element.scrollHeight;

	const progressPercentage =
		((maxTweetLength - element.value.length) / maxTweetLength) * 100;
	const progress = `${progressPercentage.toFixed(2)}%`;

	// update state
	body.value = element.value;

	// styles
	progressElement.style.setProperty("--progress", progress);
	element.style.height = `auto`;
	element.style.height = `${scHeight}px`;
};
</script>

<style>

section{
	grid-area: tweet;
}

textarea:focus {
	outline: none;
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
