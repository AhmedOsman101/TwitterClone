<template>
  <section id="Tweets" class="grid">

  </section>
</template>

<script setup>
defineProps({posts: Array});
</script>

<style scoped>
#Tweets {
  grid-template-rows: 1fr 2fr 1fr;
}
</style>