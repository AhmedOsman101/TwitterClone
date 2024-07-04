<script setup>
import { useGlobalState } from "@/stores/globalDataStore.js";
import { computed } from "vue";

const props = defineProps({option: String, type: String});

const GlobalState = useGlobalState();

const activeOption = computed(() => {
  return props.type === 'notification' ? GlobalState.activeNotificationOption :
         GlobalState.activeProfileOption;
});

</script>

<template>
  <div
      class="flex justify-center flex-1 p-3 hover:bg-gray-950 transition duration-300 cursor-pointer relative thinBorder-r"
      @click="GlobalState.setActiveOption(type, option)">
    {{ option }}
    <div
        v-if="option === activeOption.value"
        class="absolute bottom-0 w-10 h-1 rounded-full bg-sky-400"/>
  </div>
</template>
