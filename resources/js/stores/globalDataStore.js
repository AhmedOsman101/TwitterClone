// store.js
import { ref } from "vue";
import { createGlobalState } from "@vueuse/core";

export const useGlobalState = createGlobalState(() => {
	const activeNotificationOption = ref("all");
	const activeProfileOption = ref("posts");

	/**
	 * The function `setActiveOption` sets the value of either the active notification or profile option
	 * based on the specified type.
	 * @param {string} type - The `type` parameter is used to determine which active option to set.
	 * @param {string} value - The `value` parameter represents the new value that
	 * you want to set for the active option based on the `type` specified.
	 */
	function setActiveOption(type, value) {
		if (type === "notification") {
			activeNotificationOption.value = value;
		} else if (type === "profile") {
			activeProfileOption.value = value;
		}
	}

	return {
		activeNotificationOption,
		setActiveOption,
	};
});
