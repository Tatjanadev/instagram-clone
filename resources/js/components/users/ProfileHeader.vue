<script setup lang="ts">
import type { ProfileUser } from "@/types/user";

defineProps<{
    user: ProfileUser;
}>();
</script>

<template>
    <div class="mx-auto max-w-2xl p-6">
        <h1 class="mb-4 text-center text-xl font-semibold">
            {{ user.username }}
        </h1>
        <div class="flex items-center gap-8">
            <div class="avatar">
                <div class="w-24 rounded-full">
                    <img
                        v-if="user.profile_photo_path"
                        :src="`/storage/${user.profile_photo_path}`"
                        alt="User profile photo"
                    />
                    <div
                        v-else
                        class="bg-base-300 flex h-24 w-24 items-center justify-center rounded-full text-2xl font-semibold"
                    >
                        {{ user.username.charAt(0).toUpperCase() }}
                    </div>
                </div>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-value">{{ user.posts_count }}</div>
                    <div class="stat-title">Posts</div>
                </div>

                <div class="stat">
                    <div class="stat-value">{{ user.followers_count }}</div>
                    <div class="stat-title">Followers</div>
                </div>

                <div class="stat">
                    <div class="stat-value">{{ user.following_count }}</div>
                    <div class="stat-title">Following</div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p class="font-semibold">
                {{ user.first_name }} {{ user.last_name }}
            </p>
            <p v-if="user.bio" class="mt-1">
                {{ user.bio }}
            </p>
        </div>
    </div>
</template>
