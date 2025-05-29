export const ProfileOptions = {
  Posts: "posts",
  Likes: "likes",
  Replies: "replies",
} as const;

export const NotificationTypes = {
  Like: "like",
  Reply: "reply",
  Follow: "follow",
} as const;

export const NotificationOptions = {
  All: "all",
  Read: "read",
  Unread: "unread",
} as const;

export type ProfileOption =
  (typeof ProfileOptions)[keyof typeof ProfileOptions];
export type NotificationType =
  (typeof NotificationTypes)[keyof typeof NotificationTypes];
export type NotificationOption =
  (typeof NotificationOptions)[keyof typeof NotificationOptions];
