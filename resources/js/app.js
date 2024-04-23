import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import Layout from "./Pages/Shared/Layout.vue";

import "@fortawesome/fontawesome-free/css/all.css"; // Ensure your project is capable of handling css files

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link)
            .component("Layout", Layout)
            .mount(el);
    },
    progress: { showSpinner: true },
});
