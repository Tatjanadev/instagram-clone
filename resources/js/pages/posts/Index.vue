<script setup lang="ts">
defineProps<{
    posts: Array<{
        id: number;
        title: string;
        description: string | null;
    }>;
}>();
</script>

<template>
    <div>
        <h1>Posts</h1>

        <div v-if="posts.length === 0">
            No posts yet.
        </div>

        <div v-else>
            <div v-for="post in posts" :key="post.id">
                <h2>{{ post.title }}</h2>
                <p>{{ post.description }}</p>
            </div>
        </div>
    </div>
</template>