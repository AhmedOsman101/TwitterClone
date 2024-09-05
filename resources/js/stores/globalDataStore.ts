import { NotificationOptions, ProfileOptions } from "@/types/Enums";
import { createGlobalState } from "@vueuse/core";
import { Ref, ref } from "vue";

export const useGlobalState = createGlobalState(() => {
  const activeNotificationOption: Ref<NotificationOptions> = ref(
    NotificationOptions.All
  );
  const activeProfileOption: Ref<ProfileOptions> = ref(ProfileOptions.Posts);

  function setActiveProfileOption(value: ProfileOptions): void {
    activeProfileOption.value = value;
  }

  function setActiveNotificationOption(value: NotificationOptions): void {
    activeNotificationOption.value = value;
  }

  return {
    activeNotificationOption,
    activeProfileOption,
    setActiveProfileOption,
    setActiveNotificationOption,
  };
});
