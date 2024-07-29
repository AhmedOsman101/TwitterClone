import { Store } from "pinia";
import { NotificationTypes } from "./Enums";

export interface User {
	id: number;
	username: string;
	full_name: string;
	profile_picture: string;
	unreadCount: number;
}

export interface IProfileUser {
	id: number;
	full_name: string;
	username: string;
	email: string;
	bio?: string | null;
	cover_photo?: string;
	profile_picture: string;
	followers_count?: number;
	following_count?: number;
	created_at: string;

	following?: IShortUser[];
	followers?: IShortUser[];
}

export interface IShortUser {
	id: number;
	username: string;
	full_name: string;
	profile_picture: string;
}

export interface INotifications {
	all: INotification[] | null;
	read: INotification[] | null;
	unread: INotification[] | null;
}

export interface INotification {
	id: string;
	type: NotificationTypes;
	username: string;
	full_name: string;
	message: string;
	profile_picture: string;
	tweet_id: number | null;
	created_at: string;
	read_at: string | null;
}

export interface IComment {
	id: number;
	user_id: number;
	tweet_id: number;
	body: string;
	liked: boolean;
	likes_count: number;
	duration: string;
	user: IShortUser;
}

export interface ITweet {
	id: number;
	user_id: number;
	body: string;
	likes_count?: number;
	comments_count?: number;
	liked?: boolean;
	created_at?: string;
	duration?: string;
	user: IShortUser;
}

export interface ISidebarLink {
	href: string;
	label: string;
	icon: string;
	active: boolean;
}

export type PageProps<
	T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
	auth: {
		user: User;
	};
};

export type AuthStore = Store<
	"auth",
	{
		user: User;
	},
	{},
	{
		updateAuthenticatedUser(data: User): void;
		setAuthenticatedUser(data: User): void;
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
