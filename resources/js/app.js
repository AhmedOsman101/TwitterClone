import "./bootstrap";
import "../css/app.css";
import "@fortawesome/fontawesome-free/css/all.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";
import { useAuthStore } from "./stores/authStore";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .component("Link", Link);

        // Initialize the auth store and fetch the authenticated user
        const authStore = useAuthStore();
        authStore.getAuthenticatedUser().then(() => {
            // Mount the app after the user has been fetched
            app.mount(el);
        });
        return app;
    },
    progress: {
        color: "#38bdf8",
        showSpinner: true,
    },
});
