<template>
	<section id="Home">
		<SideBar />
		<slot />
	</section>
</template>

<script setup>
import SideBar from "./SideBar.vue";
</script>

<style scoped>
section {
	grid-template-areas:
		"nav tweet aside"
		"nav posts aside";

	display: grid;
	grid-template-columns: 20.1rem 1fr 20.1rem;
}
</style>
