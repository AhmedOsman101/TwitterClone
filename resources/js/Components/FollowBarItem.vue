<template>
  <div class="followerGrid">
    <img alt="image" class="w-9 aspect-square rounded-md bg-gray-500" src="https://placehold.co/400">
    <div class="flex flex-col ml-2">
      <p class="font-semibold text-sm text-gray-200 hover:underline transition cursor-pointer">full name</p>
      <p class="font-semibold text-sm text-gray-400 transition cursor-pointer -mt-1">@username</p>
    </div>
    <div class="FollowBtn w-full">
      <button
          class="bg-white rounded-3xl px-4 py-1.5 grid items-center font-extrabold text-sm text-black w-fit h-fit">
        Follow
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