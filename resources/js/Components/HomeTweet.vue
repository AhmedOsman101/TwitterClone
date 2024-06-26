<script setup>
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import { useFeedStore } from "@/stores/feedStore.js";
import InputError from "./InputError.vue";

// hooks
const page = usePage();
const authStore = useAuthStore();
const feedStore = useFeedStore();

// refs & variables
const maxTweetLength = 280;
const input = ref(null);
const body = ref("");
const {user} = storeToRefs(authStore);

// computed properties
const errors = computed(() => page.props.errors);

onMounted(() => {
  input.value.focus();
});

// methods
const createTweet = (id) => {
  const data = {
    user_id: id,
    body: body.value,
  };
  feedStore.addNewTweet(data);

  if (!errors.value.body) body.value = "";

  input.value.style.height = `auto`;
};

const autoResize = () => {
  const element = input.value;
  const progressElement = document.querySelector(".progress");

  // Reset the height to auto to calculate the new scroll height
  element.style.height = 'auto';
  let scHeight = element.scrollHeight;

  const progressPercentage =
      ((maxTweetLength - element.value.length) / maxTweetLength) * 100;
  const progress = `${progressPercentage.toFixed(2)}%`;

  // Update state
  body.value = element.value;

  // Update styles
  progressElement.style.setProperty("--progress", progress);
  element.style.height = `${scHeight}px`;
};

</script>

<template>
  <section id="Tweet" class="flex flex-col w-full h-fit max-h-screen">
    <div class="flex place-items-center px-5 mt-9">
      <div class="rounded-full h-fit mr-4">
        <img
            :src="user.profile_picture"
            alt="profile"
            class="max-h-full max-w-full w-12 aspect-square rounded-full"
        />
      </div>
      <textarea
          ref="input"
          v-model="body"
          :maxlength="maxTweetLength"
          class="block dark:bg-black text-xl w-full p-4 px-0 disabled:opacity-80 resize-none ring-0 dark:placeholder-neutral-500 dark:text-white"
          cols="40"
          placeholder="What is happening?!"
          required
          rows="1"
          type="text"
          wrap="hard"
          @input="autoResize"
      >
            </textarea>
    </div>
    <div class="flex justify-end p-5 place-items-center space-x-5">
      <InputError :message="errors.body"/>
      <div
          v-show="body.length"
          :data-value="maxTweetLength - body.length"
          class="progress border"
      />
      <button
          :disabled="!body.length"
          class="bg-sky-500 px-5 py-2 rounded-3xl opacity-100 text-white font-semibold disabled:opacity-80"
          @click="() => createTweet(user.id)"
      >
        Tweet
      </button>
    </div>
    <hr/>
  </section>
</template>

<style scoped>
section {
  grid-area: tweet;
}

textarea:focus, textarea:active {
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
