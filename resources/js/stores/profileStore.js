import axios from "axios";
import { defineStore } from "pinia";
import { useAuthStore } from "./authStore";

/**
 * @typedef {Object} User
 * @property {number} id - The user ID
 * @property {string} username - The user's username
 * @property {string} full_name - The user's full name
 * @property {string} profile_picture - The URL to the user's profile picture
 */

/**
 * @typedef {Object} Tweet
 * @property {number} id - The tweet ID
 * @property {number} user_id - The ID of the user who created the tweet
 * @property {string} body - The content of the tweet
 * @property {number|null} likes_count - The number of likes the tweet has received
 * @property {number|null} comments_count - The number of comments the tweet has received
 * @property {boolean|null} liked - Whether the tweet is liked by the current user
 * @property {string|null} created_at - The creation date of the tweet
 * @property {string|null} duration - The time duration since the tweet was created
 * @property {User|null} user - The user who created the tweet
 */

/**
 * @typedef {'posts'|'liked'|'replied'} Options
 * */

export const useProfileStore = defineStore("profile", {
  state: () => {
    return {
      /**
       * @type {Tweet[]}
       */
      posts: [],
      /**
       * @type {Tweet[]}
       */
      liked: [],
      /**
       * @type {Tweet[]}
       */
      replied: [],
    };
  },
  actions: {
    /**
     * Sets the home feed with an array of tweets.
     * @param {Options} type - Which feed to set.
     * @param {Options} value - The currently selected feed.
     */
    setFeed (type, value) {
      this.$patch((state) => (state[type] = value));
    },

    /**
     * Fetches the selected feed from the server.
     * @param {Options} type - Which feed to get.
     * @param {string} username - Which user we want to fetch his feed.
     * @returns {Promise<void>}
     */
    async getFeed (type, username) {
      try {
        const authStore = useAuthStore();

        const request = await axios.get(route("feed.home"), {
          params: {user_id: authStore.user.id},
        });

        const response = await request.data;

        this.setFeed(type, response);
      } catch (e) {
        console.error("Error Fetching Home Feed:", e);
      }
    },
  },
});
