<template>
  <section id="Home">
    <SideBar />
    <slot />
  </section>
</template>

<script setup>
import SideBar from "../Layout./Layouts/SideBar.vue";
</script>

<style scoped>
section {
  grid-template-areas:
    "nav header followBar"
    "nav tweet followBar"
    "nav feed followBar";

  display: grid;
  grid-template-columns: 20rem 1fr 20rem;
  grid-template-rows: auto auto 1fr;
}
</style>
