<template>
    <aside class="px-5 py-4 w-fit h-screen flex flex-col items-start gap-6">
        <NavLink href="/">🐦</NavLink>
        <NavLink href="/">🏠 Home</NavLink>
        <NavLink href="/notifications">🔔 Notifications</NavLink>
        <NavLink href="/profile">🧔🏻 Profile</NavLink>
        <NavLink href="/user/logout" method="post">Logout</NavLink>
        <NavLink ></NavLink>
    </aside>
</template>

<script setup>
import NavLink from "./NavLink.vue";
</script>
