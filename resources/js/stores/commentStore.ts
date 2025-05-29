import { router } from "@inertiajs/vue3";
import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import { isEqualObjects } from "@/lib/utils";
import type { IComment } from "@/types";
import { useAuthStore } from "./authStore";
import { useFeedStore } from "./feedStore";

export const useCommentStore = defineStore("comment", () => {
  const comments = ref<IComment[]>([]);
  /**
   * Sets the home comments with an array of comments.
   * @param comments - An array of comments.
   */
  function setComments(data: IComment[]) {
    comments.value = data;
  }
  /**
   * Fetches the home comments from the server.
   */
  async function getComments(id: number): Promise<void> {
    try {
      const authStore = useAuthStore();
      const request = await axios.get(route("comments.index"), {
        params: { tweetId: id, userId: authStore.user.id },
      });
      const response = await request.data;
      setComments(response);
    } catch (e) {
      console.error("Error Fetching Home Comments: ", e);
    }
  }

  /**
   * The `addNewComment` function logs the tweet ID, sends a POST request to store a comment, and
   * then fetches and updates the comments and tweet in the feed.
   * @param data - The `data` parameter in the `addNewComment` function likely contains information
   * about the comment being added, such as the content of the comment, the user who posted it, and
   * the tweet ID to which the comment is being added. This data is used to make a POST request to
   * the server
   */
  function addNewComment(data: Partial<IComment>) {
    // biome-ignore lint/suspicious/noExplicitAny: This function has a wierd signature
    router.post(route("comment.store"), data as any, {
      onSuccess: async () => {
        if (data.tweetId) {
          await getComments(data.tweetId);
          const feedStore = useFeedStore();
          await feedStore.fetchTweet(data.tweetId);
        }
      },
    });
  }

  /**
   * Updates a comment in the comments.
   * @param comment - The comment to update.
   */
  function updateComment(comment: IComment[]) {
    const target: IComment = comment[0];

    // find the comment in the comments
    const index = comments.value.findIndex(item => item.id === target.id);

    // check if comment is not found
    if (index < 0) throw new Error("COMMENT IS NOT FOUND!!!!!!!!!!!!!");

    // check if comments are not equal then continue and update the comment
    if (!isEqualObjects(target, comments.value[index])) {
      comments.value[index] = target;
    }
  }
  /**
   * Fetches a comment by its ID and updates it in the comments.
   * @param id - The ID of the comment to fetch.
   */
  async function fetchComment(id: number): Promise<void> {
    const authStore = useAuthStore();
    const request = await axios.get(route("comments.show", id), {
      params: { userId: authStore.user.id },
    });
    const response = await request.data;
    updateComment(response);
  }

  return {
    comments,
    setComments,
    getComments,
    addNewComment,
    updateComment,
    fetchComment,
  };
});
