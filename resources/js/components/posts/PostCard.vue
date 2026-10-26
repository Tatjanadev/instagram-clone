<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import { Heart } from "lucide-vue-next";
import { show as userShow } from "@/routes/users";
import { useI18n } from "vue-i18n";
import { ref } from "vue";
import axios, { AxiosError } from "axios";

const { t } = useI18n();

const props = defineProps<{
    id: number;
    userId: number;
    currentUserId: number;
    username: string;
    profilePhotoPath: string | null;
    title: string;
    description: string | null;
    likesCount: number;
    isLiked: boolean;
    imagePath: string | null;
}>();

const liked = ref(props.isLiked);
const likes = ref(props.likesCount);
const isProcessing = ref(false);

const toggleLike = async () => {
    if (isProcessing.value) {
        return;
    }

    isProcessing.value = true;

    const wasLiked = liked.value;

    liked.value = !wasLiked;
    likes.value += wasLiked ? -1 : 1;

    try {
        if (wasLiked) {
            await axios.delete(`/posts/${props.id}/like`);
        } else {
            await axios.post(`/posts/${props.id}/like`);
        }
    } catch (error) {
        const axiosError = error as AxiosError<{
            already_liked?: boolean;
            already_unliked?: boolean;
            likes_count?: number;
        }>;
        const response = axiosError.response;

        if (
            response?.status === 422 &&
            typeof response.data.likes_count === "number" &&
            (response.data.already_liked === true ||
                response.data.already_unliked === true)
        ) {
            liked.value = response.data.already_liked === true;
            likes.value = response.data.likes_count;
        } else {
            liked.value = wasLiked;
            likes.value += wasLiked ? 1 : -1;

            console.error("Failed to update like:", error);
        }
    } finally {
        isProcessing.value = false;
    }
};

const deletePost = () => {
    const confirmed = window.confirm(t("posts.delete_confirmation"));
    if (!confirmed) {
        return;
    }

    router.delete(`/posts/${props.id}`);
};
</script>

<template>
    <div class="card bg-base-100 w-96 shadow-sm">
        <Link :href="userShow(username)" class="flex items-center gap-3 p-4">
            <div class="avatar">
                <div class="h-10 w-10 rounded-full">
                    <img
                        v-if="profilePhotoPath"
                        :src="`/storage/${profilePhotoPath}`"
                        :alt="t('posts.profile_photo')"
                    />

                    <div
                        v-else
                        class="bg-base-300 flex h-10 w-10 items-center justify-center rounded-full font-semibold"
                    >
                        {{ username.charAt(0).toUpperCase() }}
                    </div>
                </div>
            </div>

            <span class="font-semibold">
                {{ username }}
            </span>
        </Link>
        <Link :href="`/posts/${id}`">
            <figure v-if="imagePath">
                <img :src="imagePath" :alt="title" />
            </figure>

            <div class="card-body">
                <h2 class="card-title">
                    {{ title }}
                </h2>

                <p v-if="description">
                    {{ description }}
                </p>
            </div>
        </Link>

        <div class="card-actions justify-end p-4">
            <button
                type="button"
                class="btn btn-ghost btn-circle tooltip"
                :data-tip="liked ? t('posts.unlike') : t('posts.like')"
                :disabled="isProcessing"
                @click="toggleLike"
            >
                <Heart
                    :size="22"
                    :class="liked ? 'text-red-500' : ''"
                    :fill="liked ? 'currentColor' : 'none'"
                />
            </button>

            <span>{{ likes }}</span>

            <Link
                v-if="userId === currentUserId"
                :href="`/posts/${id}/edit`"
                class="btn btn-sm btn-accent"
            >
                {{ t("posts.edit") }}
            </Link>

            <button
                v-if="userId === currentUserId"
                type="button"
                class="btn btn-sm btn-error"
                @click="deletePost"
            >
                {{ t("posts.delete") }}
            </button>
        </div>
    </div>
</template>
