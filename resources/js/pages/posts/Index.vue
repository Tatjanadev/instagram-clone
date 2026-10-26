<script setup lang="ts">
import { useI18n } from "vue-i18n";
import PostCard from "@/components/posts/PostCard.vue";

const { t } = useI18n();

defineProps<{
    posts: Array<{
        id: number;
        user_id: number;
        title: string;
        description: string | null;
        likes_count: number;
        is_liked: boolean;
        images: Array<{
            id: number;
            image_path: string;
        }>;
        user: {
            id: number;
            username: string;
            profile_photo_path: string | null;
        };
    }>;
    currentUserId: number;
}>();
</script>

<template>
    <div>
        <h1>{{ t("posts.posts") }}</h1>

        <div v-if="posts.length === 0">{{ t("posts.no_posts_yet") }}</div>

        <div v-else class="flex flex-wrap gap-6">
            <PostCard
                v-for="post in posts"
                :key="post.id"
                :id="post.id"
                :title="post.title"
                :description="post.description"
                :likes-count="post.likes_count"
                :is-liked="post.is_liked"
                :image-path="
                    post.images.length
                        ? `/storage/${post.images[0].image_path}`
                        : null
                "
                :user-id="post.user_id"
                :current-user-id="currentUserId"
                :username="post.user.username"
                :profile-photo-path="post.user.profile_photo_path"
            />
        </div>
    </div>
</template>
