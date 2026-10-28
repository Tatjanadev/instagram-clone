<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';

const { t } = useI18n();

// Each like contains the post that the user liked.
type LikedPost = {
    id: number;
    post: {
        id: number;
        title: string;
        likes_count: number;
        images: Array<{
            id: number;
            image_path: string;
        }>;
    };
};

// Receive the liked posts from Laravel through Inertia.
defineProps<{
    likedPosts: LikedPost[];
}>();
</script>

<template>
    <div class="mx-auto max-w-5xl p-6">
        <h1 class="mb-6 text-xl font-semibold">
            {{ t('likes.liked_posts') }}
        </h1>

        <!-- Show a message when the user has no liked posts. -->
        <p v-if="likedPosts.length === 0">
            {{ t('likes.no_liked_posts') }}
        </p>

        <!-- Display liked posts in a responsive grid. -->
        <div v-else class="grid grid-cols-2 gap-4 md:grid-cols-3">
            <Link
                v-for="like in likedPosts"
                :key="like.id"
                :href="`/posts/${like.post.id}`"
                class="group"
            >
                <div
                    class="bg-base-200 relative aspect-square overflow-hidden rounded-lg"
                >
                    <img
                        v-if="like.post.images.length > 0"
                        :src="`/storage/${like.post.images[0].image_path}`"
                        :alt="like.post.title"
                        class="h-full w-full object-cover transition-transform group-hover:scale-105"
                    />

                    <!-- Show the likes count when hovering over the image. -->
                    <div
                        class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 text-white opacity-0 transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100"
                    >
                        <Heart :size="22" fill="currentColor" />

                        <span class="font-semibold">
                            {{ like.post.likes_count }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>
