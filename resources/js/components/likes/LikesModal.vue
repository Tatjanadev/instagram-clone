<script setup lang="ts">
import { useI18n } from "vue-i18n";
import { ref, watch } from "vue";
import axios from "axios";
import { Link } from '@inertiajs/vue3';
import { show as userShow } from '@/routes/users';

const { t } = useI18n();

const props = defineProps<{
    isOpen: boolean;
    postId: number;
}>();

const emit = defineEmits<{
    close: [];
}>();

// Describes the data returned by Laravel for each like.
type Like = {
    id: number;
    user: {
        id: number;
        username: string;
        first_name: string | null;
        last_name: string | null;
        profile_photo_path: string | null;
    };
};

const likes = ref<Like[]>([]);
const isLoading = ref(false);
const hasError = ref(false);

watch(
    () => props.isOpen,
    async (isOpen) => {
        if (!isOpen) {
            return;
        }

        isLoading.value = true;
        hasError.value = false;
        likes.value = [];

        try {
            const response = await axios.get<{ likes: Like[] }>(
                `/posts/${props.postId}/likes`,
            );

            likes.value = response.data.likes;
        } catch (error) {
            console.error("Failed to load likes:", error);
            hasError.value = true;
        } finally {
            isLoading.value = false;
        }
    },
);
</script>

<template>
    <dialog class="modal" 
    :open="isOpen"
     @click.self="emit('close')"
    @keydown.esc="emit('close')"
    >
        <div class="modal-box">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">
                    {{ t("likes.liked_by") }}
                </h2>

                <button
                    type="button"
                    class="btn btn-sm btn-circle btn-ghost"
                    @click="emit('close')"
                >
                    ✕
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto py-4">
                <!-- Show a loading spinner while fetching likes from Laravel. -->
                <div v-if="isLoading" class="flex justify-center">
                    <span class="loading loading-spinner loading-md"></span>
                    <span class="ml-2">{{ t("likes.loading") }}</span>
                </div>

                <p v-else-if="hasError">
                    {{ t("likes.load_error") }}
                </p>
                 <!-- Show a message if the post has no likes. -->
                <p v-else-if="likes.length === 0">
                    {{ t("likes.no_likes") }}
                </p>
                <!-- Display the users when likes have been loaded successfully. -->
                <div v-else class="flex flex-col gap-4">
                    <Link
                        v-for="like in likes"
                        :key="like.id"
                        :href="userShow(like.user.username)"
                        class="flex items-center gap-3"
                        @click="emit('close')"
                    >
                        <div class="avatar">
                            <div class="h-10 w-10 rounded-full">
                                 <!-- Show the profile photo if the user has one. -->
                                <img
                                    v-if="like.user.profile_photo_path"
                                    :src="`/storage/${like.user.profile_photo_path}`"
                                    :alt="like.user.username"
                                />

                                <div
                                    v-else
                                    class="bg-base-300 flex h-10 w-10 items-center justify-center rounded-full font-semibold"
                                >
                                    {{
                                        like.user.username
                                            .charAt(0)
                                            .toUpperCase()
                                    }}
                                </div>
                            </div>
                        </div>
                         <!-- Display the username and full name underneath. -->
                        <div class="flex flex-col">
                            <span class="font-semibold">
                                {{ like.user.username }}
                            </span>
                             <!-- Remove missing names and join the rest with a space. -->
                            <span class="text-base-content/60 text-sm">
                                {{
                                    [like.user.first_name, like.user.last_name]
                                        .filter(Boolean)
                                        .join(" ")
                                }}
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </dialog>
</template>
