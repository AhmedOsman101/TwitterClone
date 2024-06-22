import axios from "axios";
import { isEqualObjects } from "@/Helpers";
import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";
import { toRaw } from "vue";
import { useAuthStore } from "./authStore";

export const useFeedStore = defineStore("feed", {
  state: () => {
    return {
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
       * @type {Tweet[]}
       */
      feed: [],
    };
  },
  actions: {
    /**
     * Sets the home feed with an array of tweets.
     * @param {Tweet[]} feed - An array of tweets.
     */
    setHomeFeed (feed) {
      this.$patch((state) => (state.feed = feed));
      console.log(toRaw(this.feed), 'Feed Set');
    },
    /**
     * Fetches the home feed from the server.
     * @returns {Promise<void>}
     */
    async getHomeFeed () {
      try {
        const authStore = useAuthStore();

        const request = await axios.get(route('feed.home'), {
          params: {user_id: authStore.user.id},
        });
        const response = await request.data;
        await this.setHomeFeed(response);
      } catch (e) {
        console.error("Error Fetching Home Feed:", e);
      }
    },
    /**
     * Adds a new tweet and refreshes the home feed.
     * @param {Tweet} data - The data for the new tweet.
     */
    addNewTweet (data) {
      router.post(route('tweet.store'), data, {
        onSuccess: () => this.getHomeFeed(),
      });
    },
    /**
     * Updates a tweet in the feed.
     * @param {Tweet[]} tweet - The tweet to update.
     */
    updateTweet (tweet) {
      /**
       * @type {Tweet}
       */
      const param = tweet[0];
      // find the tweet in the feed
      let index = this.feed.findIndex((item) => item.id === param.id);
      // check if tweet is not found
      if (index < 0) throw new Error("TWEET IS NOT FOUND!!!!!!!!!!!!!");
      // check if tweets are not equal then continue and update the tweet
      if (!isEqualObjects(param, this.feed[index])) {
        this.$patch((state) => (state.feed[index] = param));
      }
    },
    /**
     * Fetches a tweet by its ID and updates it in the feed.
     * @param {number} id - The ID of the tweet to fetch.
     * @returns {Promise<void>}
     */
    async fetchTweet (id) {
      const authStore = useAuthStore();
      const request = await axios.get(route('tweets.api.show', id), {
        params: {user_id: authStore.user.id},
      });
      const response = await request.data;
      this.updateTweet(response);
    },
  },
});
