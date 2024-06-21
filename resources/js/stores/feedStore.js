import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";
import axios from "axios";

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
    setHomeFeed(feed) {
      this.$patch((state) => {
        state.feed = feed;
      });
      // this.feed = feed;
      console.log(this.feed);
    },
    /**
     * Fetches the home feed from the server.
     * @returns {Promise<void>}
     */
    async getHomeFeed() {
      try {
        const request = await axios.post("http://localhost:8000/feed/home");
        const response = await request.data;
        // await this.setHomeFeed(response);
        await this.$patch((state) => {
          state.feed = response;
        });
      } catch (e) {
        console.error("Error Fetching Home Feed:", e);
      }
    },
    /**
     * Adds a new tweet and refreshes the home feed.
     * @param {Tweet} data - The data for the new tweet.
     */
    addNewTweet(data) {
      router.post("tweet", data, {
        onSuccess: () => {
          this.getHomeFeed();
        },
      });
    },
    /**
     * Updates a tweet in the feed.
     * @param {Tweet} tweet - The tweet to update.
     */
    updateTweet(tweet) {
      console.log(tweet[0]);
      let index = this.feed.findIndex((item) => item.id === tweet.id);
      this.$patch((state) => {
        state.feed[index] = tweet[0];
      });
      // this.feed[index] = tweet[0];
    },
    /**
     * Fetches a tweet by its ID and updates it in the feed.
     * @param {number} id - The ID of the tweet to fetch.
     * @returns {Promise<void>}
     */
    async fetchTweet(id) {
      const request = await axios.get(`/tweets/${id}`);
      const response = await request.data;
      this.updateTweet(response);
    },
  },
});
