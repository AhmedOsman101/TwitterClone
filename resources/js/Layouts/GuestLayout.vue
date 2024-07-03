<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-black">
        <div>
            <Link :href="route('Home')">
                <ApplicationLogo class="w-20 h-20 fill-current text-sky-400" />
            </Link>
        </div>

        <div class="w-full max-w-lg sm:max-w-lg mt-6 px-5 py-4 bg-white dark:bg-black thinBorder shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
