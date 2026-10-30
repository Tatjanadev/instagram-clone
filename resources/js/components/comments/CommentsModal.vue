<script setup lang="ts">
import { ref, watch } from "vue";
import { X } from "lucide-vue-next";
import { useI18n } from "vue-i18n";
import type { Comment } from "@/types/comment";
import CommentList from "@/components/comments/CommentList.vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import CommentForm from "@/components/comments/CommentForm.vue";

const { t } = useI18n();

const props = defineProps<{
    isOpen: boolean;
    postId: number;
    currentUserId: number;
}>();

const emit = defineEmits<{
    close: [];
}>();

//It contains all the comments retrieved from Laravel through Axios.
const comments = ref<Comment[]>([]);
const isLoading = ref(false);
const hasError = ref(false);
const isSubmitting = ref(false);
const commentError = ref<string | null>(null);
const commentForm = ref<InstanceType<typeof CommentForm> | null>(null);

const loadComments = async () => {
    isLoading.value = true;
    hasError.value = false;

    try {
        const response = await axios.get(`/posts/${props.postId}/comments`);

        comments.value = response.data.comments;
    } catch (error) {
        hasError.value = true;
        console.error("Failed to load comments:", error);
    } finally {
        isLoading.value = false;
    }
};

watch(
    () => props.isOpen,
    (isOpen) => {
        if (!isOpen) {
            return;
        }

        comments.value = [];
        commentError.value = null;
        loadComments();
    },
);
const handleCommentSubmit = (body: string) => {
    if (isSubmitting.value) {
        return;
    }

    commentError.value = null;

    router.post(
        `/posts/${props.postId}/comments`,
        { body },
        {
            preserveScroll: true,
            preserveState: true,

            onStart: () => {
                isSubmitting.value = true;
            },

            onSuccess: async () => {
                commentForm.value?.clearForm();
                await loadComments();
            },

            onError: (errors) => {
                commentError.value = errors.body ?? t("comments.create_failed");
            },

            onFinish: () => {
                isSubmitting.value = false;
            },
        },
    );
};
</script>

<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
        @click.self="emit('close')"
    >
        <div class="bg-base-100 w-full max-w-lg rounded-xl p-5 shadow-xl">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">
                       {{ t("comments.title") }} ({{ comments.length }})
                </h2>

                <button
                    type="button"
                    class="btn btn-ghost btn-circle btn-sm"
                    @click="emit('close')"
                >
                    <X :size="20" />
                </button>
            </div>

            <p v-if="isLoading">
                {{ t("comments.loading") }}
            </p>

            <p v-else-if="hasError" class="text-error">
                {{ t("comments.load_failed") }}
            </p>
            <!-- Display the comments retrieved from Laravel. -->
            <CommentList
                v-else
                :comments="comments"
                :current-user-id="currentUserId"
            />

            <!-- Form for creating a new comment. -->
            <div class="mt-4">
                <CommentForm
                    ref="commentForm"
                    :is-submitting="isSubmitting"
                    :error="commentError"
                    @submit="handleCommentSubmit"
                />
            </div>
        </div>
    </div>
</template>
