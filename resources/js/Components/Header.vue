<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

defineProps({title: String, backable: Boolean});

const page = usePage();

const head = ref(null);
const component = computed(() => getComponent(page));

onMounted(() => {
  head.value.focus();
  // Attach the scroll event listener when the component is mounted
  window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
  // Remove the scroll event listener when the component is unmounted
  window.removeEventListener("scroll", handleScroll);
});

const getComponent = (page) => {
  let component = page.component;
  component = component.split("/");
  const index = component.length - 1;
  component = component[index];
  return component;
};

const handleScroll = (e) => {
  // Apply a blur filter along with a transparent background
  head.value.style.background = "rgba(0, 0, 0, 0.5)";
  head.value.style.backdropFilter = "blur(10px)";
};

const back = () => {
  // Go back to the previous page
  window.history.back();
};
</script>

<template>
  <section ref="head" class="pl-5 py-4 border-b sticky top-0 bg-black">
    <div class="flex gap-4 items-center w-full">
      <button v-if="backable"
              class="p-3 aspect-square grid place-items-center rounded-full hover:bg-[#181919]"
              @click="back">
        <i class="fa-solid fa-arrow-left"/>
      </button>
      <h1 class="text-2xl font-bold">{{ $props.title ?? component }}</h1>
    </div>
  </section>
</template>
