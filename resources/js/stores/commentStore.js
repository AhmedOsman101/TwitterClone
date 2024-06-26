import axios from "axios";
import { isEqualObjects } from "@/Helpers";
import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";
import { useAuthStore } from "./authStore";
import { useFeedStore } from "@/stores/feedStore.js";

export const useCommentStore = defineStore("comments", {
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
       * @typedef {Object} Comment
       * @property {number} id - The comment ID
       * @property {number} user_id - The ID of the user who created the comment
       * @property {string} body - The content of the comment
       * @property {boolean|null} liked - Whether the comment is liked by the current user
       * @property {number|null} likes_count - The number of likes the comment has received
       * @property {string|null} duration - The time duration since the comment was created
       * @property {User|null} user - The user who created the comment
       */

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
      // console.log(toRaw(this.comments), 'Comments Set');
    },
    /**
     * Fetches the home comments from the server.
     * @returns {Promise<void>}
     */
    async getComments (id) {
      try {
        const authStore = useAuthStore();
        const request = await axios.get(route('comments.index'), {
          params: {tweet_id: id, user_id: authStore.user.id},
        });
        const response = await request.data;
        await this.setComments(response);
      } catch (e) {
        console.error("Error Fetching Home Comments:", e);
      }
    },

    addNewComment (data) {
      console.log(data.tweet_id, "add");
      router.post(route('comment.store'), data, {
        onSuccess: () => {
          this.getComments(data.tweet_id);
          const feedStore = useFeedStore();
          feedStore.fetchTweet(data.tweet_id);
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
      const request = await axios.get(route('comments.show', id), {
        params: {user_id: authStore.user.id},
      });
      const response = await request.data;
      this.updateComment(response);
    },
  },
});
