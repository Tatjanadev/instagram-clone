<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PostForm from '@/components/posts/PostForm.vue';
</script>

<template>
    <Head title="Create post" />
    <div class="flex justify-center p-6">
        <PostForm />
    </div>
</template>