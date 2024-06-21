<template>
  <p v-if="error" class="text-red-600 pt-1" v-text="error" />
</template>

<script setup>
defineProps({ error: String });
</script>
