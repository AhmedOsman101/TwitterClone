<script setup>

import FollowBarItem from "@/Components/FollowBarItem.vue";
</script>

<template>
  <div class="min-h-screen w-full FollowBar thinBorder-l p-7">
    <div class="rounded-2xl border py-4 px-5">
      <h3 class="text-lg font-semibold mb-3">Who to Follow</h3>
      <div class="space-y-5">
        <FollowBarItem v-for="n in 3"/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.FollowBar {
  grid-area: followBar;
}

</style>