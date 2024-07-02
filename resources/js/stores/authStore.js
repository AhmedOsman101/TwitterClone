import { defineStore } from "pinia";

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
     * @property {User} user - The user information
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
    async updateAuthenticatedUser (data) {
      this.$patch((state) => state.user = {...state.user, ...data});
    },

    setAuthenticatedUser (data) {
      this.user = data;
    },
    /**
     * Logs out the user by sending a request to the API and resets the state.
     * @async
     * @function logout
     * @returns {Promise<void>} A promise that resolves when the user is logged out and the state is reset.
     */
    async logout () {
      this.$reset();
    },
  },
});
