import { ProfileOptions } from "./Enums";
import { Store } from "pinia";
import { IComment, ITweet, IUser } from "./Interfaces";

export type AuthStore = Store<
	"auth",
	{
		user: IUser;
	},
	{},
	{
		updateAuthenticatedUser(data: IUser): void;
		setAuthenticatedUser(data: IUser): void;
		logout(): void;
		fetchUser(): void;
	}
>;

export type CommentStore = Store<
	"comments",
	{
		comments: IComment[];
	},
	{},
	{
		setComments(comments: IComment[]): void;
		getComments(id: number): Promise<void>;
		addNewComment(data: IComment): void;
		updateComment(comment: IComment[]): void;
		fetchComment(id: number): Promise<void>;
	}
>;

export type FeedStore = Store<
	"feed",
	{
		feed: ITweet[];
	},
	{},
	{
		setFeed(feed: ITweet[]): void;
		getFeed(): Promise<void>;
		addNewTweet(data: ITweet): void;
		updateTweet(tweet: ITweet[]): void;
		fetchTweet(id: number): Promise<void>;
	}
>;

export type ProfileStore = Store<
	"profile",
	{
		posts: ITweet[];
		liked: ITweet[];
		replies: ITweet[];
	},
	{},
	{
		setFeed(type: ProfileOptions, value: ITweet[]): void;
		getFeed(
			type: ProfileOptions,
			target_id: number,
			user_id: number
		): Promise<void>;
	}
>;
