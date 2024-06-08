import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import Layout from "./src/Layout/Layout.vue";

import "@fortawesome/fontawesome-free/css/all.css";

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob("./src/**/*.vue", { eager: true });
		return pages[`./src/${name}.vue`];
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
