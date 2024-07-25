import { defineStore } from "pinia";
import axios from "axios";
import { IUser } from "@/lib/Interfaces";

export const useAuthStore = defineStore("auth", {
	state: () => {
		return {
			user: {
				id: null,
				full_name: null,
				username: null,
				email: null,
				bio: null,
				cover_photo: null,
				profile_picture: null,
				created_at: null,
				following_count: null,
				followers_count: null,
				notifications: {
					all: [],
					read: [],
					unread: [],
				},
			} as IUser,
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
		updateAuthenticatedUser(data: IUser): void {
			this.$patch(
				(state: { user: IUser }) =>
					(state.user = { ...state.user, ...data })
			);
		},

		/**
		 * Sets the authenticated user in the store.
		 * @param data - The user data to set.
		 * @returns
		 */
		setAuthenticatedUser(data: IUser): void {
			this.$patch((state: { user: IUser }) => (state.user = data));
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
