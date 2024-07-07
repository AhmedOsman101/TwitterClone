import axios from "axios";
import { isEqualObjects } from "@/Helpers";
import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";
import { useAuthStore } from "./authStore";
import { useFeedStore } from "@/stores/feedStore.js";

/**
 * @typedef {Object} CommentUser
 * @property {number} id - The user ID
 * @property {string} username - The user's username
 * @property {string} full_name - The user's full name
 * @property {string} profile_picture - The URL to the user's profile picture
 */

/**
 * @typedef {Object} Comment
 * @property {number} id - The comment ID
 * @property {number} user_id - The ID of the user who created the comment
 * @property {number} tweet_id - The ID of the tweet the user commented on.
 * @property {string} body - The content of the comment
 * @property {boolean|null} liked - Whether the comment is liked by the current user
 * @property {number|null} likes_count - The number of likes the comment has received
 * @property {string|null} duration - The time duration since the comment was created
 * @property {CommentUser|null} user - The user who created the comment
 */

export const useCommentStore = defineStore("comments", {
  state: () => {
    return {
      /**
       * @type {Comment[]}
       */
      comments: [],
    };
  },
  actions: {
    /**
     * Sets the home comments with an array of comments.
     * @param {Comment[]} comments - An array of comments.
     */
    setComments (comments) {
      this.$patch((state) => (state.comments = comments));
    },
    /**
     * Fetches the home comments from the server.
     * @returns {Promise<void>}
     */
    async getComments (id) {
      try {
        const authStore = useAuthStore();
        const request = await axios.get(route("comments.index"), {
          params: {tweet_id: id, user_id: authStore.user.id},
        });
        const response = await request.data;
        this.setComments(response);
      } catch (e) {
        console.error("Error Fetching Home Comments:", e);
      }
    },

    /**
     * The `addNewComment` function logs the tweet ID, sends a POST request to store a comment, and
     * then fetches and updates the comments and tweet in the feed.
     * @param {Comment} data - The `data` parameter in the `addNewComment` function likely contains information
     * about the comment being added, such as the content of the comment, the user who posted it, and
     * the tweet ID to which the comment is being added. This data is used to make a POST request to
     * the server
     */
    addNewComment (data) {
      router.post(route("comment.store"), data, {
        onSuccess: () => {
          this.getComments(data.tweet_id).then(() => {
            const feedStore = useFeedStore();
            feedStore.fetchTweet(data.tweet_id);
          });
        },
      });
    },
    /**
     * Updates a comment in the comments.
     * @param {Comment[]} comment - The comment to update.
     */
    updateComment (comment) {
      /**
       * @type {Comment}
       */
      const param = comment[0];
      // find the comment in the comments
      let index = this.comments.findIndex((item) => item.id === param.id);

      // check if comment is not found
      if (index < 0) throw new Error("COMMENT IS NOT FOUND!!!!!!!!!!!!!");

      // check if comments are not equal then continue and update the comment
      if (!isEqualObjects(param, this.comments[index])) {
        this.$patch((state) => (state.comments[index] = param));
      }
    },
    /**
     * Fetches a comment by its ID and updates it in the comments.
     * @param {number} id - The ID of the comment to fetch.
     * @returns {Promise<void>}
     */
    async fetchComment (id) {
      const authStore = useAuthStore();
      const request = await axios.get(route("comments.show", id), {
        params: {user_id: authStore.user.id},
      });
      const response = await request.data;
      this.updateComment(response);
    },
  },
});
