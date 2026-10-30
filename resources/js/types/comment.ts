export type Comment = {
    id: number;
    body: string;
    user: {
        id: number;
        username: string;
        first_name: string;
        last_name: string;
        profile_photo_path: string | null;
    };
};
