<script setup lang="ts">
import PostCard from "@/components/posts/PostCard.vue";

defineProps<{
    posts: Array<{
        id: number;
        user_id: number;
        title: string;
        description: string | null;
        images: Array<{
            id: number;
            image_path: string;
        }>;
    }>;
     currentUserId: number;
}>();
</script>

<template>
    <div >
        <h1>Posts</h1>

        <div v-if="posts.length === 0">No posts yet.</div>

        <div v-else class="flex flex-wrap gap-6">
            <PostCard
                v-for="post in posts"
                :key="post.id"
                :id="post.id"
                :title="post.title"
                :description="post.description"
                :image-path="
                    post.images.length
                        ? `/storage/${post.images[0].image_path}`
                        : null
                "
                :user-id="post.user_id"
                :current-user-id="currentUserId"
            />
        </div>
    </div>
</template>
