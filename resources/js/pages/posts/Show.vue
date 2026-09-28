<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import PostCard from "@/components/posts/PostCard.vue";

defineProps<{
    post: {
        id: number;
        user_id: number;
        title: string;
        description: string | null;
        images: Array<{
            id: number;
            image_path: string;
        }>;
    };
    currentUserId: number;
}>();
</script>

<template>
    <div class="flex flex-col items-center p-6">

        <div class="mb-3 flex w-96 items-center gap-3">
            <Link
                href="/posts"
                class="btn btn-circle btn-sm tooltip"
                data-tip="Back to posts"
            >
                <ArrowLeft :size="22" />
            </Link>
             <h1 class="text-lg font-semibold">
                Post
            </h1>
        </div>
        <PostCard
            :id="post.id"
            :user-id="post.user_id"
            :current-user-id="currentUserId"
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
