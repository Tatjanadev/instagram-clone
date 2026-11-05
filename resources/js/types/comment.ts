import type { User } from './user';

export type Comment = {
    id: number;
    body: string;
    user: Pick<
    User, 
    'id' | 'username' | 'first_name' | 'last_name' | 'profile_photo_path'
    >;
};
