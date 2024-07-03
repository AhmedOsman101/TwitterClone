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

const notificationType = computed(() => props.notification.type);

const formattedMessage = computed(() => {
  let input = props.notification.message;
  let startIndex = -1;
  if (notificationType.value === "follow") {
    startIndex = input.indexOf("started");

    const part1 = input.substring(0, startIndex);
    const part2 = input.substring(startIndex);

    return {part1, part2};
  }
  if (notificationType.value === "like") {
    startIndex = input.indexOf("liked");
    let middleIndex = input.indexOf("your");

    const part1 = input.substring(0, startIndex);

    const part2 = input.substring(startIndex, middleIndex);

    const part3 = input.substring(middleIndex);

    return {part1, part2, part3};
  }
  if (notificationType.value === "reply") {
    startIndex = input.indexOf("replied");
    let middleIndex = input.indexOf("your");

    const part1 = input.substring(0, startIndex);

    const part2 = input.substring(startIndex, middleIndex);

    const part3 = input.substring(middleIndex);

    return {part1, part2, part3};
  }
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
  router.put(
      route("notifications.update"),
      {id},
      {
        onSuccess: () => {
          authStore.fetchUser();
        },
      },
  );
};

const dismiss = (id) => {
  axios
      .delete(route("notifications.destroy"), {data: {id}})
      .then(() => authStore.fetchUser());
};
</script>

<template>
  <div :class="{'opacity-50' : notification.read_at !== null}" class="notification pl-5 pt-5 thinBorder-b">
    <Link
        :href="route('profile.index', notification.username)"
        class="w-fit h-fit rounded-full image cursor-pointer">
      <img
          :alt="notification.full_name"
          :src="notification.profile_picture"
          class="w-10 h-10 rounded-full bg-gray-500"/>
    </Link>
    <div class="flex align-start gap-3 notificationHead">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold text-gray-200 hover:underline transition cursor-pointer h-fit"
          v-text="notification.full_name"/>
      <span class="text-gray-400">•</span>
      <p class="font-semibold text-gray-400" v-text="notification.created_at"/>
    </div>

    <p v-if="notificationType === 'follow'" class="notificationBody">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold hover:underline"
          v-text="formattedMessage.part1"/>
      <span v-text="formattedMessage.part2"/>
    </p>

    <p
        v-if="notificationType === 'like' || notificationType === 'reply'"
        class="notificationBody">
      <Link
          :href="route('profile.index', notification.username)"
          class="font-semibold hover:underline"
          v-text="formattedMessage.part1"/>
      <span v-text="formattedMessage.part2"/>
      <Link
          :href="route('tweet.show', notification.tweet_id)"
          class="hover:underline"
          v-text="formattedMessage.part3"/>
    </p>

    <div class="actions">
      <button
          class="action_button thinBorder group"
          @click="dismiss(notification.id)"
          @mouseenter="showTooltip(2)"
          @mouseleave="hideTooltip(2)">
        <i class="fa-solid fa-xmark"/>
        <Tooltip :message="'Dismiss'" :visible="tooltip_2"/>
      </button>

      <button
          v-show="notification.read_at === null"
          class="action_button thinBorder group"
          @click="markAsRead(notification.id)"
          @mouseenter="showTooltip(1)"
          @mouseleave="hideTooltip(1)">
        <i class="fa-solid fa-check"/>
        <Tooltip :message="'Mark as Read'" :visible="tooltip_1"/>
      </button>
    </div>
  </div>
</template>

<style scoped>
.notification {
  display: grid;
  grid-template-rows: repeat(2, auto);
  grid-template-columns: auto 4fr 1fr;
  gap: 0.8rem;
  grid-template-areas:
		"image header actions"
		"body body link";
  @apply min-h-fit h-fit pr-4;
}

.notificationHead {
  grid-area: header;
}

.notificationBody {
  grid-area: body;
  @apply text-lg pr-1 pb-8 whitespace-break-spaces;
}

.actions {
  grid-area: actions;
  @apply flex flex-row-reverse justify-between items-center h-full w-full;
}

.action_button {
  @apply rounded-full bg-black hover:bg-gray-950 relative aspect-square h-full;
}
</style>
