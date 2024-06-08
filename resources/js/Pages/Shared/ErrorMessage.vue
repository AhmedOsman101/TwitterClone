<template>
  <p v-if="error" class="text-red-600 pt-1">{{ error }}</p>
</template>

<script setup>
defineProps({error: Object})
</script>