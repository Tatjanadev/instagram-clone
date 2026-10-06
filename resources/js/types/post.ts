export type PostImage = {
    id: number;
    image_path: string;
};

export type Post = {
    id: number;
    images: PostImage[];
};
