import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import "@fortawesome/fontawesome-free/css/all.css";
import { createPinia } from "pinia";
import { useAuthStore } from "@/stores/authStore.js";

const pinia = createPinia();

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob("./src/**/*.vue", { eager: true });
    return pages[`./src/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .component("Link", Link);

    // Initialize the auth store and fetch the authenticated user
    const authStore = useAuthStore();
    authStore.getAuthenticatedUser().then(() => {
      // Mount the app after the user has been fetched
      app.mount(el);
    });
  },
  progress: { showSpinner: true },
});
