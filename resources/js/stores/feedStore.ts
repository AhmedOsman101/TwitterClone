import { isEqualObjects } from "@/lib/Helpers";
import { ITweet } from "@/types";
import { router } from "@inertiajs/vue3";
import { useAxios } from "@vueuse/integrations/useAxios";
import axios from "axios";
import { defineStore } from "pinia";
import { useAuthStore } from "./authStore";

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
			this.$patch((state) => (state.feed = feed));
		},

		/**
		 * Fetches the home feed from the server.
		 */
		async getFeed(): Promise<void> {
			try {
				const authStore = useAuthStore();

				const request = await axios.get(route("feed.home"), {
					params: { userId: authStore.user.id },
				});

				const response = await request.data;

				this.setFeed(response);
			} catch (e) {
				console.error("Error Fetching Home Feed:", e);
			}
		},

		/**
		 * Adds a new tweet and refreshes the home feed.
		 * @param body - The data for the new tweet.
		 */
		addNewTweet(body: string): void {
			router.post(
				route("tweet.store"),
				{ body },
				{
					onSuccess: () => this.getFeed(),
				},
			);
		},

		/**
		 * Updates a tweet in the feed.
		 * @param tweet - The tweet to update.
		 */
		updateTweet(tweet: ITweet): void {
			console.log("update tweet", this.feed);
			// find the tweet in the feed
			let index = this.feed.findIndex(
				(item: { id: number }) => item.id === tweet.id,
			);

			// check if tweet is not found
			if (index < 0) throw new Error("TWEET IS NOT FOUND!!!!!!!!!!!!!");

			// check if tweets are not equal then continue and update the tweet
			if (!isEqualObjects(tweet, this.feed[index])) {
				this.$patch((state) => (state.feed[index] = tweet));
			}
		},

		/**
		 * Fetches a tweet by its ID and updates it in the feed.
		 * @param id - The ID of the tweet to fetch.
		 */
		async fetchTweet(id: number): Promise<void> {
			const authStore = useAuthStore();
			const { data: tweet } = await useAxios(route("tweets.api.show", id), {
				params: { userId: authStore.user.id },
			});

			this.updateTweet(tweet.value as ITweet);
		},
	},
});
