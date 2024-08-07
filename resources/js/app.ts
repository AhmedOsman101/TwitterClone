import "./bootstrap";
import "../css/app.css";
import "@fortawesome/fontawesome-free/css/all.css";
import "vue3-emoji-picker/css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const pinia = createPinia();

createInertiaApp({
	title: (title) => `${title ?? appName}`,
	resolve: (name) =>
		resolvePageComponent(
			`./Pages/${name}.vue`,
			import.meta.glob<DefineComponent>("./Pages/**/*.vue")
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
