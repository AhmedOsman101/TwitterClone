import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";

// Vuetify
import "vuetify/styles";
import "@fortawesome/fontawesome-free/css/all.css"; // Ensure your project is capable of handling css files
import { createVuetify } from "vuetify";
import { aliases, fa } from "vuetify/iconsets/fa";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "fa",
        aliases,
        sets: {
            fa,
        },
    },
});

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .component("Link", Link)
            .mount(el);
    },
    progress: { showSpinner: true },
});
