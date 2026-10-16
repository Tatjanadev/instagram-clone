<script setup lang="ts">
import { Head, Link, router, setLayoutProps } from '@inertiajs/vue3';
import { watchEffect } from 'vue';
import { useI18n } from 'vue-i18n';
import { show as profileShow } from '@/routes/profile';
import { edit as userEdit } from '@/routes/user';
import PostGrid from '@/components/posts/PostGrid.vue';
import ProfileHeader from '@/components/users/ProfileHeader.vue';
import type { ProfileUser } from '@/types/user';
import { follow, unfollow } from '@/routes/users';

const { t } = useI18n();

const props = defineProps<{
    user: ProfileUser;
    isOwnProfile: boolean;
    isFollowing: boolean;
}>();

watchEffect(() => {
    setLayoutProps({
        breadcrumbs: [
            {
                title: t('profile.profile'),
                href: profileShow(),
            },
        ],
    });
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
            {{ t('profile.edit_profile') }}
        </Link>

        <button
            v-if="!isOwnProfile && !isFollowing"
            class="btn btn-primary mt-3"
            @click="followUser"
        >
            {{ t('profile.follow') }}
        </button>

        <button
            v-if="!isOwnProfile && isFollowing"
            class="btn btn-outline mt-3"
            @click="unfollowUser"
        >
            {{ t('profile.unfollow') }}
        </button>
    </div>
    <PostGrid :posts="user.posts" />
</template>
