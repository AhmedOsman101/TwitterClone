import { defineStore } from "pinia";
import axios from "axios";
import { User } from "@/types";
import { useAxios } from "@vueuse/integrations/useAxios.mjs";
import AxiosInstance from "@/Axios";

export const useAuthStore = defineStore("auth", {
	state: () => {
		return {
			user: {} as User,
		};
	},

	actions: {
		/**
		 * Fetches the authenticated user data from the API and updates the user state if not already authenticated.
		 * @async
		 * @function updateAuthenticatedUser
		 * @param data The data to update the user
		 * @returns A promise that resolves when the user data is fetched and updated.
		 */
		updateAuthenticatedUser(data: User): void {
			this.$patch(
				(state: { user: User }) =>
					(state.user = { ...state.user, ...data })
			);
		},

		/**
		 * Sets the authenticated user in the store.
		 * @param data - The user data to set.
		 * @returns
		 */
		setAuthenticatedUser(data: User): void {
			this.$patch((state: { user: User }) => (state.user = data));
		},

		/**
		 * Fetches the authenticated user data from the server and updates the store.
		 */
		async fetchUser(): Promise<void> {
			// await axios
			// 	.post(route("auth.user"))
			// 	.then((res) => this.setAuthenticatedUser(res.data));

			await useAxios(route("auth.user"), AxiosInstance).then((res) =>
				this.setAuthenticatedUser(res.data as unknown as User)
			);
		},
	},
});
