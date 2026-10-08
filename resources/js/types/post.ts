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
    images: PostImage[];
    user: User;
};
