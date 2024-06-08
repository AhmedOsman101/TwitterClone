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
    "nav header aside"
		"nav tweet aside"
		"nav posts aside";

	display: grid;
	grid-template-columns: 20rem 1fr 20rem;
}
</style>
