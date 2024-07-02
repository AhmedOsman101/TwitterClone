<script setup>
import { computed, ref } from "vue";
import Tooltip from "@/Components/Tooltip.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { useAuthStore } from "@/stores/authStore.js";

const props = defineProps({notification: Object});

const authStore = useAuthStore();

const tooltip_1 = ref(false);
const tooltip_2 = ref(false);

const formattedMessage = computed(() => {
  let input = props.notification.message;
  let startIndex = -1;
  if (props.notification.type === "follow")
    startIndex = input.indexOf("started");
  if (props.notification.type === "like") startIndex = input.indexOf("liked");
  if (props.notification.type === "reply")
    startIndex = input.indexOf("replied");

  const part1 = input.substring(0, startIndex - 1); // remove the extra space
  const part2 = input.substring(startIndex);

  return {part1, part2};
});

const showTooltip = (tooltip) => {
  switch (tooltip) {
    case 1:
      tooltip_1.value = true;
      break;
    case 2:
      tooltip_2.value = true;
      break;
    default:
      tooltip_1.value = tooltip_2.value = false;
      break;
  }
};

const hideTooltip = (tooltip) => {
  switch (tooltip) {
    case 1:
      tooltip_1.value = false;
      break;
    case 2:
      tooltip_2.value = false;
      break;
    default:
      tooltip_1.value = tooltip_2.value = false;
      break;
  }
};

const markAsRead = (id) => {
  router.put(route('notifications.update'), {id}, {
    onSuccess: () => {
      authStore.fetchUser();
    }
  });
};

const dismiss = (id) => {
  axios.delete(route('notifications.destroy'), {data: {id}})
       .then(() => authStore.fetchUser());
};
</script>

<template>
  <div class="tweet pl-5 pt-5 thinBorder-b">
    <Link
        :href="route('profile.index', notification.username)"
        class="w-fit h-fit rounded-full image cursor-pointer">
      <img
          :alt="notification.full_name"
          :src="notification.profile_picture"
          class="w-10 h-10 rounded-full bg-gray-500"/>
    </Link>
    <div class="flex align-start gap-3 tweetHead">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold text-gray-200 hover:underline transition cursor-pointer h-fit"
          v-text="notification.full_name"/>
    </div>

    <p class="tweetBody">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold hover:underline"
          v-text="formattedMessage.part1"/>
      {{ formattedMessage.part2 }}
    </p>

    <div class="actions">
      <button
          class="action_button group"
          @click="markAsRead(notification.id)"
          @mouseenter="showTooltip(1)"
          @mouseleave="hideTooltip(1)">
        <i class="fa-solid fa-check"/>
        <Tooltip :message="'Mark as Read'" :visible="tooltip_1"/>
      </button>

      <button
          class="action_button group"
          @click="dismiss(notification.id)"
          @mouseenter="showTooltip(2)"
          @mouseleave="hideTooltip(2)">
        <i class="fa-solid fa-xmark"/>
        <Tooltip :message="'Dismiss'" :visible="tooltip_2"/>
      </button>
    </div>
  </div>
</template>

<style scoped>
.tweet {
  display: grid;
  grid-template-rows: repeat(2, auto);
  grid-template-columns: auto 4fr 1fr;
  gap: 0.8rem;
  grid-template-areas:
		"image header actions"
		"body body link";
  @apply min-h-fit h-fit pr-4;
}

.tweetHead {
  grid-area: header;
}

.tweetBody {
  grid-area: body;
  @apply text-lg pr-1 pb-8 whitespace-break-spaces;
}

.actions {
  grid-area: actions;
  @apply flex justify-between items-center h-full w-full;
}

.action_button {
  @apply rounded-full bg-black border-gray-600 border hover:bg-gray-950 relative aspect-square h-full;
}
</style>