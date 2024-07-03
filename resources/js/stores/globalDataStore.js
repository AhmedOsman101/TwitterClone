// store.js
import { ref } from 'vue';
import { createGlobalState } from '@vueuse/core';

export const useGlobalState = createGlobalState(
  () => {
    const activeNotificationOption = ref('all');

    function setActiveNotificationOption (value) {
      activeNotificationOption.value = value;
    }

    return {activeNotificationOption, setActiveNotificationOption};
  }
);