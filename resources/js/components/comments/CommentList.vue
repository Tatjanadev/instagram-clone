<script setup lang="ts">
import CommentItem from '@/components/comments/CommentItem.vue';
import type { Comment } from '@/types/comment';

defineProps<{
    comments: Comment[];
    currentUserId: number;
}>();
</script>

<template>
    <div class="space-y-3">
        <CommentItem
            v-for="comment in comments"
            :key="comment.id"
            :comment="comment"
            :current-user-id="currentUserId"
        />
    </div>
</template>
