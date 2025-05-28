import { isEqualObjects } from "@/lib/Helpers";
import { useFeedStore } from "@/stores/feedStore.js";
import { IComment } from "@/types";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { defineStore } from "pinia";
import { useAuthStore } from "./authStore";

export const useCommentStore = defineStore("comments", {
	state: () => {
		return {
			comments: [] as IComment[],
		};
	},
	actions: {
		/**
		 * Sets the home comments with an array of comments.
		 * @param comments - An array of comments.
		 */
		setComments(comments: IComment[]) {
			this.$patch(
				(state: { comments: IComment[] }) => (state.comments = comments),
			);
		},

		/**
		 * Fetches the home comments from the server.
		 */
		async getComments(id: number): Promise<void> {
			try {
				const authStore = useAuthStore();
				const request = await axios.get(route("comments.index"), {
					params: { tweetId: id, userId: authStore.user.id },
				});
				const response = await request.data;
				this.setComments(response);
			} catch (e) {
				console.error("Error Fetching Home Comments: ", e);
			}
		},

		/**
		 * The `addNewComment` function logs the tweet ID, sends a POST request to store a comment, and
		 * then fetches and updates the comments and tweet in the feed.
		 * @param data - The `data` parameter in the `addNewComment` function likely contains information
		 * about the comment being added, such as the content of the comment, the user who posted it, and
		 * the tweet ID to which the comment is being added. This data is used to make a POST request to
		 * the server
		 */
		addNewComment(data: { body: string; tweetId: number; targetId: number }) {
			router.post(route("comment.store"), data as any, {
				onSuccess: () => {
					this.getComments(data.tweetId).then(() => {
						const feedStore = useFeedStore();
						feedStore.fetchTweet(data.tweetId);
					});
				},
			});
		},
		/**
		 * Updates a comment in the comments.
		 * @param comment - The comment to update.
		 */
		updateComment(comment: IComment[]) {
			const target: IComment = comment[0];

			// find the comment in the comments
			let index = this.comments.findIndex(
				(item: { id: number }) => item.id === target.id,
			);

			// check if comment is not found
			if (index < 0) throw new Error("COMMENT IS NOT FOUND!!!!!!!!!!!!!");

			// check if comments are not equal then continue and update the comment
			if (!isEqualObjects(target, this.comments[index])) {
				this.$patch(
					(state: { comments: { [id: number]: IComment } }) =>
						(state.comments[index] = target),
				);
			}
		},
		/**
		 * Fetches a comment by its ID and updates it in the comments.
		 * @param id - The ID of the comment to fetch.
		 */
		async fetchComment(id: number): Promise<void> {
			const authStore = useAuthStore();
			const request = await axios.get(route("comments.show", id), {
				params: { userId: authStore.user.id },
			});
			const response = await request.data;
			this.updateComment(response);
		},
	},
});
