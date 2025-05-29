import "../css/app.css";
import "@fortawesome/fontawesome-free/css/all.css";
import "vue3-emoji-picker/css";

import { createInertiaApp, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createPinia } from "pinia";
import type { DefineComponent } from "vue";
import { createApp, h } from "vue";
import { ZiggyVue } from "ziggy-js";
import { initializeTheme } from "./composables/useAppearance";
import AxiosInstance from "./lib/axios";

// @ts-expect-error Extend ImportMeta interface for Vite...
declare module "vite/client" {
  interface ImportMetaEnv {
    readonly VITE_APP_NAME: string;
    [key: string]: string | boolean | undefined;
  }

  interface ImportMeta {
    readonly env: ImportMetaEnv;
    readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
  }
}

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const pinia = createPinia();
window.axios = AxiosInstance;

createInertiaApp({
  title: title => `${title ?? appName}`,
  resolve: name =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>("./pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .component("Link", Link)
      .mount(el);
  },
  progress: {
    color: "#38bdf8",
    showSpinner: true,
  },
});

// This will set light / dark mode on page load...
initializeTheme();
