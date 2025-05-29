import { createGlobalState } from "@vueuse/core";
import { ref } from "vue";
import {
  type NotificationOption,
  NotificationOptions,
  type ProfileOption,
  ProfileOptions,
} from "@/types/enums";

export const useGlobalState = createGlobalState(() => {
  const activeNotificationOption = ref<NotificationOption>(
    NotificationOptions.All
  );
  const activeProfileOption = ref<ProfileOption>(ProfileOptions.Posts);

  function setActiveProfileOption(value: ProfileOption): void {
    activeProfileOption.value = value;
  }

  function setActiveNotificationOption(value: NotificationOption): void {
    activeNotificationOption.value = value;
  }

  return {
    activeNotificationOption,
    activeProfileOption,
    setActiveProfileOption,
    setActiveNotificationOption,
  };
});
