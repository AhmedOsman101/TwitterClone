<script setup>
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useAuthStore } from "@/stores/authStore.js";
import { storeToRefs } from "pinia";
import { useCommentStore } from "@/stores/commentStore.js";
import InputError from "./InputError.vue";

// hooks
const page = usePage();
const authStore = useAuthStore();
const commentStore = useCommentStore();

// refs & variables
const maxCommentLength = 255;
const input = ref(null);
const body = ref("");
const {user} = storeToRefs(authStore);

// computed properties
const errors = computed(() => page.props.errors);

onMounted(() => {
  input.value.focus();
});

// methods
const createComment = (id, tweet_id) => {
  const data = {
    user_id: id,
    tweet_id,
    body: body.value,
  };

  commentStore.addNewComment(data);

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
      ((maxCommentLength - element.value.length) / maxCommentLength) * 100;
  const progress = `${progressPercentage.toFixed(2)}%`;

  // Update state
  body.value = element.value;

  // Update styles
  progressElement.style.setProperty("--progress", progress);
  element.style.height = `${scHeight}px`;
};

</script>

<template>
  <section id="Tweet" class="flex flex-col w-full h-fit">
    <div class="flex place-items-center px-5 pt-2.5 mb-3">
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
          :maxlength="maxCommentLength"
          class="block dark:bg-black text-xl w-full pt-4 disabled:opacity-80 resize-none dark:placeholder-neutral-500 dark:text-white"
          cols="40"
          placeholder="Post your reply"
          required
          rows="1"
          type="text"
          wrap="hard"
          @input="autoResize"
      >
            </textarea>
    </div>
    <div class="flex justify-end px-5 pb-5 place-items-center space-x-5">
      <InputError :message="errors.body"/>
      <div
          v-show="body.length"
          :data-value="maxCommentLength - body.length"
          class="progress border"
      />
      <button
          :disabled="!body.length"
          class="bg-sky-500 px-5 py-2 rounded-3xl opacity-100 text-white font-semibold disabled:opacity-80"
          @click="() => createComment(user.id, $page.props.tweet[0].id)"
      >
        Reply
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
