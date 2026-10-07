<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { show as profileShow } from '@/routes/profile';
import { Link } from '@inertiajs/vue3';
import { edit as userEdit } from '@/routes/user';
import { show as postShow } from '@/routes/posts';
import type { ProfileUser } from '@/types/user';

type PostImage = {
    id: number;
    image_path: string;
};

type Post = {
    id: number;
    images: PostImage[];
};

defineProps<{
    user: ProfileUser;
    isOwnProfile: boolean;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile',
                href: profileShow(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Profile" />

    <div class="mx-auto max-w-2xl p-6">
        <h1 class="mb-4 text-center text-xl font-semibold">
            {{ user.username }}
        </h1>
        <div class="flex items-center gap-8">
            <div class="avatar">
                <div class="w-24 rounded-full">
                    <img
                        v-if="user.profile_photo_path"
                        :src="`/storage/${user.profile_photo_path}`"
                        alt="User profile photo"
                    />
                    <div
                        v-else
                        class="bg-base-300 flex h-24 w-24 items-center justify-center rounded-full text-2xl font-semibold"
                    >
                        {{ user.username.charAt(0).toUpperCase() }}
                    </div>
                </div>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-value">{{ user.posts_count }}</div>
                    <div class="stat-title">Posts</div>
                </div>

                <div class="stat">
                    <div class="stat-value">{{ user.followers_count }}</div>
                    <div class="stat-title">Followers</div>
                </div>

                <div class="stat">
                    <div class="stat-value">{{ user.following_count }}</div>
                    <div class="stat-title">Following</div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p class="font-semibold">
                {{ user.first_name }} {{ user.last_name }}
            </p>

            <p v-if="user.bio" class="mt-1">
                {{ user.bio }}
            </p>
        </div>
        <Link
            v-if="isOwnProfile"
            :href="userEdit()"
            class="btn btn-outline mt-3"
        >
            Edit Profile
        </Link>
    </div>
    <div class="mx-auto mt-8 max-w-3xl border-t pt-4">
        <div class="grid grid-cols-3 gap-1">
            <Link
                v-for="post in user.posts"
                :key="post.id"
                :href="postShow(post.id)"
                class="group aspect-square overflow-hidden transition-transform duration-200 hover:scale-[1.02]"
            >
                <img
                    v-if="post.images.length > 0"
                    :src="`/storage/${post.images[0].image_path}`"
                    alt="Post image"
                    class="h-full w-full object-cover transition-opacity duration-200 group-hover:opacity-90"
                />
            </Link>
        </div>
    </div>
</template>
