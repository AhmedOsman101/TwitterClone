import { NotificationType } from "./Enums";

export interface IUser {
	id: number;
	full_name: string;
	username: string;
	email: string;
	bio?: string | null;
	cover_photo?: string;
	profile_picture: string;
	created_at: string;

	notifications?: INotifications;
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
	all: INotification[];
	read: INotification[];
	unread: INotification[];
}

export interface INotification {
	id: string;
	type: NotificationType;
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
	user_id?: number;
	tweet_id?: number;
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
	likes_count?: number | null;
	comments_count?: number | null;
	liked?: boolean | null;
	created_at?: string | null;
	duration?: string | null;
	user: IUser | IShortUser;
}
