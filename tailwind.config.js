import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
	content: [
		"./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
		"./storage/framework/views/*.php",
		"./resources/views/**/*.blade.php",
		"./resources/js/**/*.vue",
	],

	darkMode: "class",

	theme: {
		extend: {
			fontFamily: {
				sans: ["Figtree", ...defaultTheme.fontFamily.sans],
			},
			transitionDuration: {
				400: "400ms",
			},
		},
	},

	plugins: [
		forms,
		function ({ addUtilities }) {
			const newUtilities = {
				".debug": {
					borderWidth: "2px",
					borderColor: "#e11d48",
				},
				".thinBorder": {
					borderWidth: "0.02rem",
					borderColor: "#4b5563", // Equivalent to border-gray-600
				},
				".thinBorder-r": {
					borderRightWidth: "0.02rem",
					borderColor: "#4b5563",
				},
				".thinBorder-l": {
					borderLeftWidth: "0.02rem",
					borderColor: "#4b5563",
				},
				".thinBorder-t": {
					borderTopWidth: "0.02rem",
					borderColor: "#4b5563",
				},
				".thinBorder-b": {
					borderBottomWidth: "0.02rem",
					borderColor: "#4b5563",
				},
				".thinBorder-x": {
					borderLeftWidth: "0.02rem",
					borderRightWidth: "0.02rem",
					borderColor: "#4b5563",
				},
				".thinBorder-y": {
					borderTopWidth: "0.02rem",
					borderBottomWidth: "0.02rem",
					borderColor: "#4b5563",
				},
			};

			addUtilities(newUtilities, ["responsive", "hover"]);
		},
	],
};
