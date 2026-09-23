<script setup lang="ts">
import PostCard from "@/components/posts/PostCard.vue";

defineProps<{
    post: {
        id: number;
        title: string;
        description: string | null;
        images: Array<{
            id: number;
            image_path: string;
        }>;
    };
}>();
</script>

<template>
    <div class="flex justify-center p-6">
        <PostCard
            :title="post.title"
            :description="post.description"
            :image-path="
                post.images.length
                    ? `/storage/${post.images[0].image_path}`
                    : null
            "
        />
    </div>
</template>