<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { show as profileShow } from "@/routes/profile";
import { Link } from "@inertiajs/vue3";
import { edit as userEdit } from "@/routes/user";
import PostGrid from "@/components/posts/PostGrid.vue";
import ProfileHeader from "@/components/users/ProfileHeader.vue";
import type { ProfileUser } from "@/types/user";

defineProps<{
    user: ProfileUser;
    isOwnProfile: boolean;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Profile",
                href: profileShow(),
            },
        ],
    },
});
</script>

<template>
    <Head :title="user.username" />

    <ProfileHeader :user="user" />

    <div class="mx-auto max-w-2xl px-6">
        <Link
            v-if="isOwnProfile"
            :href="userEdit()"
            class="btn btn-outline mt-3"
        >
            Edit Profile
        </Link>
    </div>

    <PostGrid :posts="user.posts" />
</template>
