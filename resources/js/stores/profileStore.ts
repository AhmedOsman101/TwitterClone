import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { FullUser, IComment, ITweet } from "@/types";
import { type ProfileOption, ProfileOptions } from "@/types/enums";

export const useProfileStore = defineStore("profile", () => {
  const user = ref({} as FullUser);
  const posts = ref([] as ITweet[]);
  const liked = ref([] as ITweet[]);
  const replies = ref([] as IComment[]);

  /**
   * Sets the home feed with an array of tweets.
   * @param type - Which feed to set.
   * @param value - The currently selected feed.
   */
  function setFeed(type: ProfileOption, value: ITweet[] | IComment[]) {
    if (type === ProfileOptions.Posts) {
      posts.value = value;
      console.log(value, type);
    }
    if (type === ProfileOptions.Replies) {
      replies.value = value as IComment[];
      console.log(value, type);
    }
    if (type === ProfileOptions.Likes) {
      liked.value = value;
      console.log(value, type);
    }
  }

  /**
   * Fetches the selected feed from the server.
   * @param type - Which feed to get.
   * @param targetId - Which user we want to fetch his feed.
   * @param userId - Currently Viewed user id.
   */
  async function getFeed(
    type: ProfileOption,
    targetId: number,
    userId: number
  ): Promise<void> {
    try {
      const request = await axios.post(route("profile.feed"), {
        targetId,
        userId,
      });

      const response = await request.data;

      setFeed(type, response);
    } catch (e) {
      console.error("Error Fetching Home Feed:", e);
    }
  }

  return { user, posts, liked, replies, setFeed, getFeed };
});
