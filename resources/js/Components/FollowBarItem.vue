<script lang="ts" setup>
import { StringLimit } from "@/lib/Helpers";
import { useAuthStore } from "@/stores/authStore.js";
import { AuthStore, IShortUser } from "@/types";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps<{
  user: IShortUser;
}>();

const authStore: AuthStore = useAuthStore();

const isFollowed = ref(false);

/**
 * The `addFollow` function is a method that sends a POST request using the
 * `router.post` method to create a new follow.
 *
 * @param id - The user who's been followed
 */
const addFollow = (id: number) => {
  const data = {
    followerId: authStore.user.id,
    followedUserId: id,
  };

  router.post(route("follower.store"), data, {
    preserveScroll: true,
    onSuccess: () => {
      isFollowed.value = !isFollowed.value;
    },
  });
};
</script>

<template>
  <div class="followerGrid">
    <img
      :alt="user.username"
      :src="user.profilePicture"
      class="w-9 aspect-square rounded-md bg-gray-500" />
    <div class="flex flex-col ml-2">
      <!-- For smaller screens -->
      <Link
        :href="route('profile.index', user.username)"
        class="font-semibold text-xs lg:text-sm text-gray-200 cursor-pointer block lg:hidden mb-1"
        v-text="StringLimit(user.full_name, 18)" />

      <Link
        :href="route('profile.index', user.username)"
        class="font-semibold text-xs lg:text-sm text-gray-400 transition cursor-pointer -mt-1 block lg:hidden"
        v-text="StringLimit(`@${user.username}`, 18)" />

      <!-- For large screens  -->
      <Link
        :href="route('profile.index', user.username)"
        class="font-semibold text-xs lg:text-sm text-gray-200 cursor-pointer hidden lg:block"
        v-text="StringLimit(user.full_name, 20)" />

      <Link
        :href="route('profile.index', user.username)"
        class="font-semibold text-xs lg:text-sm text-gray-400 transition cursor-pointer -mt-1 hidden lg:block"
        v-text="StringLimit(`@${user.username}`, 20)" />
    </div>
    <div class="FollowBtn w-full">
      <button
        v-if="!isFollowed"
        class="bg-gray-100 rounded-3xl lg:px-6 px-3.5 py-1.5 grid items-center font-bold text-sm text-black w-fit h-fit border"
        @click="addFollow(user.id)">
        Follow
      </button>
      <button
        v-if="isFollowed"
        class="bg-black rounded-3xl lg:px-3.5 px-3 py-1.5 grid items-center font-bold text-sm text-gray-100 w-fit h-fit border"
        @click="addFollow(user.id)">
        Following
      </button>
    </div>
  </div>
</template>

<style scoped>
.followerGrid {
  display: grid;
  grid-template-areas: "image full_name btn";
  grid-template-columns: auto auto 1fr;
  place-items: center;
}

.FollowBtn {
  grid-area: btn;
  display: flex;
  justify-content: flex-end;
}
</style>
