<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { show as postShow } from '@/routes/posts';

type PostImage = {
    id: number;
    image_path: string;
};

type Post = {
    id: number;
    images: PostImage[];
};

defineProps<{
    posts: Post[];
}>();
</script>

<template>
    <div class="mx-auto mt-8 max-w-3xl border-t pt-4">
        <div class="grid grid-cols-3 gap-1">
            <Link
                v-for="post in posts"
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
