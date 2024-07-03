import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
	state: () => {
		/**
		 * @typedef {Object} Notification
		 * @property {string} id - The notification ID
		 * @property {string} type - The type of notification
		 * @property {string} username - The username associated with the notification
		 * @property {string} full_name - The full name associated with the notification
		 * @property {string} message - The message of the notification
		 * @property {string} profile_picture - The profile picture URL associated with the notification
		 * @property {string} created_at - The creation date of the notification
		 * @property {string|null} read_at - The read date of the notification, or null if unread
		 */

		/**
		 * @typedef {Object} Notifications
		 * @property {Notification[]} read - An array of read notifications
		 * @property {Notification[]} unread - An array of unread notifications
		 */

		/**
		 * @typedef {Object} User
		 * @property {number|null} id - The user ID
		 * @property {string|null} full_name - The full name of the user
		 * @property {string|null} username - The username of the user
		 * @property {string|null} email - The email address of the user
		 * @property {string|null} bio - The bio of the user
		 * @property {string|null} cover_photo - The cover photo URL of the user
		 * @property {string|null} profile_picture - The profile picture URL of the user
		 * @property {Notifications|null} notifications - The notifications the user has
		 */

		return {
			/**
			 * @type {User}
			 */
			user: {
				id: null,
				full_name: null,
				username: null,
				email: null,
				bio: null,
				cover_photo: null,
				profile_picture: null,
				notifications: {
					read: [],
					unread: [],
				},
			},
		};
	},

	actions: {
		/**
		 * Fetches the authenticated user data from the API and updates the user state if not already authenticated.
		 * @async
		 * @function updateAuthenticatedUser
		 * @param {User} data The data to update the user
		 * @returns {Promise<void>} A promise that resolves when the user data is fetched and updated.
		 */
		updateAuthenticatedUser(data) {
			this.$patch((state) => (state.user = { ...state.user, ...data }));
		},

		/**
		 * Sets the authenticated user in the store.
		 * @param {User} data - The user data to set.
		 * @returns {void}
		 */
		setAuthenticatedUser(data) {
			this.$patch((state) => (state.user = data));
		},
		/**
		 * Logs out the user by sending a request to the API and resets the state.
		 * @async
		 * @function logout
		 * @returns {Promise<void>} A promise that resolves when the user is logged out and the state is reset.
		 */
		logout() {
			this.$reset();
		},

		/**
		 * Fetches the authenticated user data from the server and updates the store.
		 * @returns {Promise<void>}
		 */
		fetchUser() {
			axios
				.post(route("auth.get"))
				.then((res) => this.setAuthenticatedUser(res.data));
		},
	},
});
