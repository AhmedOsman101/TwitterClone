<template>
    <section
        class="flex flex-col border border-1 border-slate-300 h-56 max-h-screen"
        id="Tweet"
    >
        <div class="flex place-items-center p-5 pt-0 mt-9">
            <div class="rounded-full h-fit mr-4">
                <img
                    src="https://placehold.co/400"
                    alt="profile"
                    class="max-h-full max-w-full w-12 aspect-square rounded-full"
                />
            </div>
            <textarea
                type="text"
                @input="autoResize"
                class="block bg-black text-xl w-full p-4 px-0 disabled:opacity-80 peer resize-none ring-0 placeholder-neutral-500 text-white"
                placeholder="What is happening?!"
                rows="1"
                cols="40"
                wrap="hard"
                :maxlength="55 * 5"
            ></textarea>
        </div>
        <div class="flex justify-end p-5 place-items-center">
            <Link as="button" href="user/post"></Link>
            <div
                v-show="content.length"
                class="progress"
                :data-value="275 - content.length"
            ></div>
        </div>
    </section>
</template>

<script setup>
import { ref } from "vue";

const content = ref("");

const autoResize = (e) => {
    const element = e.target;
    const progressElement = document.querySelector(".progress");
    const progress =
        (((275 - element.value.length) / 275) * 100).toFixed(2) + "%";

    // update state
    content.value = element.value;

    // styles
    progressElement.style.setProperty("--progress", progress);
};
</script>

<style scoped>
textarea:focus {
    outline: none;
}
textarea {
    /* overflow: hidden; */
    resize: none;
    /* overflow-y: auto; */
    overflow-x: hidden;
    scrollbar-color: #0ea5e9 #2e2e2e;
    scrollbar-width: thin;
}

.progress {
    --size: 6.25rem;
    --bar-width: 1.5rem;
    scale: 0.32;
    width: var(--size);
    aspect-ratio: 1/1;
    background: conic-gradient(#0ea5e9 var(--progress, 0), #2f3336 0%);
    border-radius: 50%;
    display: grid;
    place-items: center;
}

.progress::after {
    content: attr(data-value);
    border-radius: 50%;
    background: black;
    width: calc(100% - var(--bar-width));
    aspect-ratio: 1/1;
    display: grid;
    place-items: center;
    color: whitesmoke;
    font-size: 1.9rem;
    font-weight: bold;
}
</style>
