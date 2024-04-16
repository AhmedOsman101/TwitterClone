<template>
    <section class="flex gap-4">
        <aside class="px-5 py-4 w-fit h-screen flex flex-col items-start gap-6">
            <NavLink href="/">🐦</NavLink>
            <NavLink href="/">🏠 Home</NavLink>
            <NavLink href="/notifications">🔔 Notifications</NavLink>
            <NavLink href="/profile">🧔🏻 Profile</NavLink>
            <NavLink href="/user/logout" method="post">Logout</NavLink>
            <NavLink
                as="button"
                href="user/post"
                method="post"
                class="bg-sky-500 px-5 py-3 rounded-xl"
                >Tweet</NavLink
            >
        </aside>

        <slot />
    </section>
</template>

<script setup>
import NavLink from "./NavLink.vue";
</script>
