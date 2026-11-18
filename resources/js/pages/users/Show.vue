<script setup lang="ts">
import { Head, Link, router, setLayoutProps } from "@inertiajs/vue3";
import { watchEffect } from "vue";
import { useI18n } from "vue-i18n";
import { show as profileShow } from "@/routes/profile";
import { edit as userEdit } from "@/routes/user";
import PostGrid from "@/components/posts/PostGrid.vue";
import ProfileHeader from "@/components/users/ProfileHeader.vue";
import type { ProfileUser } from "@/types/user";
import { follow, unfollow } from "@/routes/users";
import { index as usersIndex } from "@/routes/users";
import { ArrowLeft } from "@lucide/vue";

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
                title: t("profile.profile"),
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
            {{ t("profile.edit_profile") }}
        </Link>

        <div
            v-if="!isOwnProfile"
            class="mt-3 flex flex-wrap items-center justify-center gap-3"
        >
            <button
                v-if="!isFollowing"
                type="button"
                class="btn btn-primary"
                @click="followUser"
            >
                {{ t("profile.follow") }}
            </button>

            <button
                v-else
                type="button"
                class="btn btn-outline"
                @click="unfollowUser"
            >
                {{ t("profile.unfollow") }}
            </button>

            <Link
                :href="usersIndex().url"
                class="btn btn-ghost inline-flex items-center gap-2"
            >
                <ArrowLeft class="h-4 w-4" />
                {{ t("profile.back_to_users") }}
            </Link>
        </div>
    </div>

    <PostGrid :posts="user.posts" />
</template>
