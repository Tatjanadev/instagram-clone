import { Post } from "./post";

export type User = {
    id: number;
    first_name: string;
    last_name: string;
    username: string;
    profile_photo_path: string | null;
    bio: string | null;
};

export type ProfileUser = User & {
    posts_count: number;
    followers_count: number;
    following_count: number;
    posts: Post[];
};
