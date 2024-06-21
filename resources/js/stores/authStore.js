import { defineStore } from "pinia";
import axios from "axios";
import { router } from "@inertiajs/vue3";

export const useAuthStore = defineStore("auth", {
    state: () => {
        /**
         * @typedef {Object} User
         * @property {number|null} id - The user ID
         * @property {string|null} full_name - The full name of the user
         * @property {string|null} username - The username of the user
         * @property {string|null} email - The email address of the user
         * @property {string|null} bio - The bio of the user
         * @property {string|null} cover_photo - The cover photo URL of the user
         * @property {string|null} profile_picture - The profile picture URL of the user
         */

        /**
         * @type {Object}
         * @property {boolean} isAuthenticated - Indicates if the user is authenticated
         * @property {User} user - The user information
         */
        return {
            isAuthenticated: false,

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
            },
        };
    },

    actions: {
        /**
         * Fetches the authenticated user data from the API and updates the user state if not already authenticated.
         * @async
         * @function getAuthenticatedUser
         * @returns {Promise<void>} A promise that resolves when the user data is fetched and updated.
         */
        async getAuthenticatedUser() {
            try {
                if (this.isAuthenticated) return;
                const request = await axios.post(
                    "http://localhost:8000/auth/user"
                );
                const response = await request.data;
                this.setAuthenticatedUser(response.user);
                if (this.user !== null) this.setIsAuthenticated(true);
            } catch (e) {
                console.error("Error fetching authenticated user:", e);
            }
        },

        setAuthenticatedUser(data) {
            this.user = data;
            if (data == null) this.isAuthenticated = false;
        },
        /**
         * Logs out the user by sending a request to the API and resets the state.
         * @async
         * @function logout
         * @returns {Promise<void>} A promise that resolves when the user is logged out and the state is reset.
         */
        async logout() {
            this.$reset();
        },

        /**
         * Sets the authentication status of the user.
         * @function setIsAuthenticated
         * @param {boolean} value - The new authentication status.
         * @returns {void}
         */
        setIsAuthenticated(value) {
            this.isAuthenticated = value;
        },
    },
});
