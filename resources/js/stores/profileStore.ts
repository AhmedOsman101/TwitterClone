import { defineStore } from "pinia";
import { ProfileOptions } from "@/types/Enums";
import { IProfileUser, ITweet } from "@/types";
import axios from "axios";

export const useProfileStore = defineStore("profile", {
	state: () => {
		return {
			user: {} as IProfileUser,
			posts: [] as ITweet[],
			liked: [] as ITweet[],
			replies: [] as ITweet[],
		};
	},
	actions: {
		/**
		 * Sets the home feed with an array of tweets.
		 * @param type - Which feed to set.
		 * @param value - The currently selected feed.
		 */
		setFeed(type: ProfileOptions, value: ITweet[]) {
			if (type === ProfileOptions.Posts) {
				this.$patch((state: { posts: ITweet[] }) => {
					state.posts = value;
				});
				console.log(value, type);
			}
			if (type === ProfileOptions.Replies) {
				this.$patch((state: { replies: ITweet[] }) => {
					state.replies = value;
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
		 * @param user_id - Currently authenticated user id.
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
