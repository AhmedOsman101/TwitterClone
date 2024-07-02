<script setup>
import FollowBarItem from "@/Components/FollowBarItem.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/authStore.js";

const users = ref([]);

const authStore = useAuthStore();

onMounted(() => {
  axios.get(route('follower.suggest', authStore.user.id)).then((res) => users.value = res.data);
});

</script>

<template>
  <div class="min-h-screen h-screen w-full FollowBar thinBorder-l p-7 sticky top-0">
    <div v-show="users.length > 0" class="rounded-2xl border py-4 px-5">
      <h3 class="text-lg font-semibold mb-3">Who to Follow</h3>
      <div class="space-y-5">
        <FollowBarItem v-for="user in users" :key="user.id" :user="user"/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.FollowBar {
  grid-area: followBar;
}

</style>