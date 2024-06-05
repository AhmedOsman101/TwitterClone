<template>
    <section id="Home">
        <aside class="p-10 w-fit h-screen flex flex-col items-start gap-8">
            <NavLink href="/">
                <i class="fa-brands fa-twitter fa-lg mb-2"></i>
            </NavLink>

            <NavLink href="/">
                <i class="fa-solid fa-house"></i>
                Home
            </NavLink>
            <NavLink href="/notifications">
                <i class="fa-solid fa-bell"></i>
                Notifications
            </NavLink>
            <NavLink href="/profile">
                <i class="fa-solid fa-user"></i>
                Profile
            </NavLink>
            <NavLink as="button" href="/user/logout" method="post">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Logout
            </NavLink>
            <NavLink
                as="button"
                href="user/post"
                class="bg-sky-500 px-5 py-3 rounded-xl"
            >
                <i class="fa-solid fa-feather"></i>
                Tweet
            </NavLink>
        </aside>

        <slot />
    </section>
</template>

<script setup>
import NavLink from "./NavLink.vue";
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
