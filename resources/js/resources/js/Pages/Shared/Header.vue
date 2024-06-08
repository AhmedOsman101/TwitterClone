<template>
  <div>
    <button @click="back"></button>
    <h1 class="text-lg font-bold">{{ $page.component }}</h1>
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const back = () => {};
</script>

<style scoped></style>
