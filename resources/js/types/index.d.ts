import { Store } from "pinia";
import { NotificationOptions, NotificationTypes } from "./Enums";

export interface User {
	id: number;
	username: string;
	full_name: string;
	profilePicture: string;
	unreadCount: number;
}

export interface IFullUser {
	id: number;
	full_name: string;
	username: string;
	email: string;
	bio?: string | null;
	coverPhoto?: string;
	profilePicture: string;
	followers_count?: number;
	following_count?: number;
	created_at: string;

	following?: IShortUser[];
	followers?: IShortUser[];
	email_verified_at: string;
}

export interface IShortUser {
	id: number;
	username: string;
	full_name: string;
	profilePicture: string;
}

export interface INotifications {
	all: INotification[];
	read: INotification[];
	unread: INotification[];
}

export interface INotification {
	id: string;
	type: NotificationTypes;
	username: string;
	full_name: string;
	message: string;
	profilePicture: string;
	tweetId: number | null;
	created_at: string;
	read_at: string | null;
}

export interface IComment {
	id: number;
	userId: number;
	tweetId: number;
	body: string;
	liked: boolean;
	likes_count: number;
	duration: string;
	user: IShortUser;
}

export interface ITweet {
	id: number;
	userId: number;
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
		addNewTweet(body: string): void;
		updateTweet(tweet: ITweet): void;
		fetchTweet(id: number): Promise<void>;
	}
>;

export type ProfileStore = Store<
	"profile",
	{
		user: IFullUser;
		posts: ITweet[];
		liked: ITweet[];
		replies: IComment[];
	},
	{},
	{
		setFeed(type: ProfileOptions, value: ITweet[] | IComment[]): void;
		getFeed(
			type: ProfileOptions,
			targetId: number,
			userId: number,
		): Promise<void>;
	}
>;

export type GlobalDataStore = {
	activeNotificationOption: Ref<NotificationOptions>;
	activeProfileOption: Ref<ProfileOptions>;
	setActiveProfileOption: (value: ProfileOptions) => void;
	setActiveNotificationOption: (value: NotificationOptions) => void;
};
