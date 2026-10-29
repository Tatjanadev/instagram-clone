<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { show as userShow } from "@/routes/users";
import type { Comment } from "@/types/comment";

defineProps<{
    comment: Comment;
}>();
</script>

<template>
    <div class="flex items-start gap-3 py-3">
        <!-- Comment author's profile photo -->
        <Link :href="userShow(comment.user.username)">
            <div class="avatar">
                <div class="h-10 w-10 rounded-full">
                //Only display the image if the user has a profile photo path.
                    <img
                        v-if="comment.user.profile_photo_path"
                        :src="`/storage/${comment.user.profile_photo_path}`"
                        :alt="comment.user.username"
                    />

                    <!-- display the first letter of username -->
                    <div
                        v-else
                        class="bg-base-300 flex h-10 w-10 items-center justify-center rounded-full font-semibold"
                    >
                        {{ comment.user.username.charAt(0).toUpperCase() }}
                    </div>
                </div>
            </div>
        </Link>

        <!-- Comment text -->
        <div class="flex-1">
            <Link
                :href="userShow(comment.user.username)"
                class="font-semibold"
            >
                {{ comment.user.username }}
            </Link>

            <p class="wrap-break-word">
                {{ comment.body }}
            </p>
        </div>
    </div>
</template>