import { IComment, IFullUser, ITweet } from "@/types";
import { ProfileOptions } from "@/types/Enums";
import axios from "axios";
import { defineStore } from "pinia";

export const useProfileStore = defineStore("profile", {
  state: () => {
    return {
      user: {} as IFullUser,
      posts: [] as ITweet[],
      liked: [] as ITweet[],
      replies: [] as IComment[],
    };
  },
  actions: {
    /**
     * Sets the home feed with an array of tweets.
     * @param type - Which feed to set.
     * @param value - The currently selected feed.
     */
    setFeed(type: ProfileOptions, value: ITweet[] | IComment[]) {
      if (type === ProfileOptions.Posts) {
        this.$patch((state: { posts: ITweet[] }) => {
          state.posts = value;
        });
        console.log(value, type);
      }
      if (type === ProfileOptions.Replies) {
        this.$patch((state: { replies: IComment[] }) => {
          state.replies = value as IComment[];
        });
        console.log(value, type);
      }
      if (type === ProfileOptions.Likes) {
        this.$patch((state: { liked: ITweet[] }) => {
          state.liked = value;
        });
        console.log(value, type);
      }
    },

    /**
     * Fetches the selected feed from the server.
     * @param type - Which feed to get.
     * @param target_id - Which user we want to fetch his feed.
     * @param user_id - Currently Viewed user id.
     */
    async getFeed(
      type: ProfileOptions,
      target_id: number,
      user_id: number
    ): Promise<void> {
      try {
        const request = await axios.post(route("profile.feed"), {
          target_id,
          user_id,
        });

        const response = await request.data;

        this.setFeed(type, response);
      } catch (e) {
        console.error("Error Fetching Home Feed:", e);
      }
    },
  },
});
