import axios from "axios";
import { isEqualObjects } from "@/lib/Helpers";
import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";
import { useAuthStore } from "./authStore";
import { ITweet } from "@/lib/Interfaces";

export const useFeedStore = defineStore("feed", {
	state: () => {
		return {
			feed: [] as ITweet[],
		};
	},
	actions: {
		/**
		 * Sets the home feed with an array of tweets.
		 * @param feed - An array of tweets.
		 */
		setFeed(feed: ITweet[]): void {
			this.$patch((state: { feed: ITweet[] }) => (state.feed = feed));
		},

		/**
		 * Fetches the home feed from the server.
		 */
		async getFeed(): Promise<void> {
			try {
				const authStore = useAuthStore();

				const request = await axios.get(route("feed.home"), {
					params: { user_id: authStore.user.id },
				});

				const response = await request.data;

				this.setFeed(response);
			} catch (e) {
				console.error("Error Fetching Home Feed:", e);
			}
		},

		/**
		 * Adds a new tweet and refreshes the home feed.
		 * @param data - The data for the new tweet.
		 */
		addNewTweet(data: ITweet): void {
			router.post(route("tweet.store"), data as any, {
				onSuccess: () => this.getFeed(),
			});
		},

		/**
		 * Updates a tweet in the feed.
		 * @param tweet - The tweet to update.
		 */
		updateTweet(tweet: ITweet[]): void {
			const target: ITweet = tweet[0];
			// find the tweet in the feed
			let index = this.feed.findIndex(
				(item: { id: number }) => item.id === target.id
			);

			// check if tweet is not found
			if (index < 0) throw new Error("TWEET IS NOT FOUND!!!!!!!!!!!!!");

			// check if tweets are not equal then continue and update the tweet
			if (!isEqualObjects(target, this.feed[index])) {
				this.$patch(
					(state: { feed: { [id: number]: ITweet } }) =>
						(state.feed[index] = target)
				);
			}
		},

		/**
		 * Fetches a tweet by its ID and updates it in the feed.
		 * @param id - The ID of the tweet to fetch.
		 */
		async fetchTweet(id: number): Promise<void> {
			const authStore = useAuthStore();
			const request = await axios.get(route("tweets.api.show", id), {
				params: { user_id: authStore.user.id },
			});
			const response = await request.data;
			this.updateTweet(response);
		},
	},
});
