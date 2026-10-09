<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { show as profileShow } from '@/routes/profile';
import { edit as userEdit } from '@/routes/user';
import PostGrid from '@/components/posts/PostGrid.vue';
import ProfileHeader from '@/components/users/ProfileHeader.vue';
import type { ProfileUser } from '@/types/user';
import { follow, unfollow } from '@/routes/users';

const props = defineProps<{
    user: ProfileUser;
    isOwnProfile: boolean;
    isFollowing: boolean;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile',
                href: profileShow(),
            },
        ],
    },
});

function followUser() {
    router.post(follow(props.user.id).url);
}

function unfollowUser() {
    router.delete(unfollow(props.user.id).url);
}
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

        <button
            v-if="!isOwnProfile && !isFollowing"
            class="btn btn-primary mt-3"
            @click="followUser"
        >
            Follow
        </button>

        <button
            v-if="!isOwnProfile && isFollowing"
            class="btn btn-outline mt-3"
            @click="unfollowUser"
        >
            Unfollow
        </button>
    </div>
    <PostGrid :posts="user.posts" />
</template>
