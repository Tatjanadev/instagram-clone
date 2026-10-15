<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import PostForm from '@/components/posts/PostForm.vue';

const { t } = useI18n();
</script>

<template>
    <Head :title="t('posts.create_post')" />
    <div class="flex justify-center p-6">
        <PostForm />
    </div>
</template>
