import type { PageProps } from "@inertiajs/core";
import type { LucideIcon } from "lucide-vue-next";
import type { Config } from "ziggy-js";
import type { NotificationType } from "./enums";

export interface Auth {
  user: User;
}

export interface BreadcrumbItem {
  title: string;
  href: string;
}

export interface NavItem {
  title: string;
  href: string;
  icon?: LucideIcon;
  isActive?: boolean;
}

// TODO: replace this type with the `NavItem` type
export interface ISidebarLink {
  href: string;
  label: string;
  icon: string;
  active: boolean;
}

export interface SharedData extends PageProps {
  name: string;
  quote: { message: string; author: string };
  auth: Auth;
  ziggy: Config & { location: string };
  sidebarOpen: boolean;
}

// NOTE: My type definitions
export interface IShortUser {
  id: number;
  username: string;
  fullName: string;
  profilePicture: string;
}

export type User = IShortUser & { unreadCount: number };

export type FullUser = IShortUser & {
  email: string;
  bio?: string | null;
  coverPhoto?: string;
  followersCount?: number;
  followingCount?: number;
  following?: IShortUser[];
  followers?: IShortUser[];
  createdAt: string;
  updatedAt: string;
  email_verified_at: string;
};

export interface INotifications {
  all: INotification[];
  read: INotification[];
  unread: INotification[];
}

export interface INotification {
  id: string;
  type: NotificationType;
  username: string;
  fullName: string;
  message: string;
  profilePicture: string;
  tweetId: number | null;
  createdAt: string;
  readAt: string | null;
}

export interface IComment {
  id: number;
  userId: number;
  tweetId: number;
  body: string;
  liked: boolean;
  likesCount: number;
  duration: string;
  user: IShortUser;
}

export interface ITweet {
  id: number;
  userId: number;
  body: string;
  likesCount?: number;
  commentsCount?: number;
  liked?: boolean;
  createdAt?: string;
  duration?: string;
  user: IShortUser;
}

export type BreadcrumbItemType = BreadcrumbItem;
