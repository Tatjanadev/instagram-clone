<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PostForm from '@/components/posts/PostForm.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

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
    <Head title="Edit Post" />

    <div class="flex flex-col items-center p-6">
        <h1 class="mb-6 text-2xl font-bold">{{ t('posts.edit_post') }}</h1>

        <PostForm :post="post" />
    </div>
</template>
