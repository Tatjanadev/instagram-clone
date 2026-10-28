import type { User } from './user';

export type PostImage = {
    id: number;
    image_path: string;
};

export type Post = {
    id: number;
    user_id: number;
    title: string;
    description: string | null;
    likes_count: number;
    is_liked: boolean;
    images: PostImage[];
    user: User;
};
