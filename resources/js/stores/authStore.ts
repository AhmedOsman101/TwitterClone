import { defineStore } from "pinia";
import axios from "axios";
import { User } from "@/types";

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
		 * Logs out the user by resetting the state.
		 */
		logout(): void {
			this.$reset();
		},

		/**
		 * Fetches the authenticated user data from the server and updates the store.
		 */
		fetchUser(): void {
			axios
				.post(route("auth.get"))
				.then((res) => this.setAuthenticatedUser(res.data));
		},
	},
});
