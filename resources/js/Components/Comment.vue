<script setup>
import { useCommentStore } from "@/stores/commentStore.js";
import { useAuthStore } from "@/stores/authStore.js";
import { formatNumber } from "@/Helpers.js";

defineProps({ comment: Object });

const commentStore = useCommentStore();
const authStore = useAuthStore();

const addLike = (user_id, comment_id) => {
	axios
		.post(route("like.store"), {
			user_id,
			comment_id,
			isComment: true,
		})
		.then(() => {
			commentStore.fetchComment(comment_id);
		});
};
</script>

<template>
	<div class="comment pl-5 pt-5 thinBorder-b hovered cursor-pointer">
		<Link
			:href="route('profile.index', comment.user.username)"
			class="w-fit h-fit rounded-full image">
			<img
				:alt="comment.user.full_name"
				:src="comment.user.profile_picture"
				class="w-10 h-10 rounded-full bg-gray-500" />
		</Link>
		<div class="flex align-start gap-3 commentHead">
			<Link
				:href="route('profile.index', comment.user.username)"
				class="font-semibold text-gray-200 hover:underline transition"
				v-text="comment.user.full_name" />
			<Link
				:href="route('profile.index', comment.user.username)"
				class="font-semibold text-gray-400 hover:underline transition"
				v-text="`@${comment.user.username}`" />
			<span class="text-gray-400">•</span>
			<p class="font-semibold text-gray-400" v-text="comment.duration" />
		</div>

		<p class="commentBody" v-text="comment.body" />

		<div class="tweetFooter">
			<p
				class="footerItem text-gray-400 hover:text-pink-500"
				@click.stop="addLike(authStore.user.id, comment.id)">
				<i
					:class="{
						'fa-regular': !comment.liked,
						'fa-solid text-pink-500': comment.liked,
					}"
					class="fa-heart" />
				<span
					v-if="comment.likes_count"
					v-text="formatNumber(comment.likes_count)" />
			</p>
		</div>
	</div>
</template>

<style scoped>
.comment {
	display: grid;
	grid-template-rows: auto auto 3rem;
	grid-template-columns: auto 1fr;
	gap: 0.8rem;
	grid-template-areas:
		"image header"
		"image body"
		"image footer";
	@apply min-h-fit h-fit;
}

.image {
	grid-area: image;
}

.commentHead {
	grid-area: header;
}

.commentBody {
	grid-area: body;
	@apply text-lg font-semibold pr-1 whitespace-break-spaces;
}

.hovered:hover {
	background-color: #04070e;
}

.tweetFooter {
	grid-area: footer;
	@apply flex gap-5 items-center;
}

.footerItem {
	@apply flex justify-between items-center gap-2 h-fit transition duration-500 cursor-pointer;
	font-size: 1rem;
}
</style>
