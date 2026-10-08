<script setup lang="ts">
import PostCard from "@/components/posts/PostCard.vue";
import { Link } from '@inertiajs/vue3';
import type { Post } from "@/types/post";
import type { User } from "@/types/user";
import { show as userShow } from '@/routes/users';

defineProps<{
    users: User[];
    posts: Post[];
    currentUserId: number;
}>();
</script>

<template>
    <div class="mx-auto mb-6 max-w-xl overflow-x-auto">
        <div class="flex gap-4">
            <Link
                v-for="user in users"
                :key="user.id"
                :href="userShow(user.username)"
                class="flex min-w-16 flex-col items-center"
            >
                <div class="avatar">
                    <div class="h-16 w-16 rounded-full">
                        <img
                            v-if="user.profile_photo_path"
                            :src="`/storage/${user.profile_photo_path}`"
                            alt="Profile photo"
                        />

                        <div
                            v-else
                            class="bg-base-300 flex h-16 w-16 items-center justify-center rounded-full font-semibold"
                        >
                            {{ user.username.charAt(0).toUpperCase() }}
                        </div>
                    </div>
                </div>

                <span class="mt-1 max-w-16 truncate text-sm">
                    {{ user.username }}
                </span>
            </Link>
        </div>
    </div>
    <div class="mx-auto flex max-w-xl flex-col gap-6 py-6">
        <PostCard
            v-for="post in posts"
            :key="post.id"
            :id="post.id"
            :user-id="post.user_id"
            :current-user-id="currentUserId"
            :username="post.user.username"
            :profile-photo-path="post.user.profile_photo_path"
            :title="post.title"
            :description="post.description"
            :image-path="
                post.images.length > 0
                    ? `/storage/${post.images[0].image_path}`
                    : null
            "
        />
    </div>
</template>
