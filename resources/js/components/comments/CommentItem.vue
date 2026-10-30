<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { show as userShow } from "@/routes/users";
import type { Comment } from "@/types/comment";
import { Pencil, Trash2 } from "lucide-vue-next";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const props = defineProps<{
    comment: Comment;
    currentUserId: number;
}>();

const isEditing = ref(false);
const isSaving = ref(false);
const editedBody = ref(props.comment.body);
const isDeleting = ref(false);
// Store the validation error when editing a comment.
const editError = ref<string | null>(null);

const startEditing = () => {
    //Copies the current comment text into our editing variable.
    editedBody.value = props.comment.body;
    editError.value = null;
    isEditing.value = true;
};

const cancelEditing = () => {
    //Closes the textarea and displays the original comment again
    isEditing.value = false;
    editedBody.value = props.comment.body;
    editError.value = null;
};

const saveComment = () => {
    const body = editedBody.value.trim();

    if (!body || isSaving.value) {
        return;
    }

    // Clear any previous validation error before saving.
    editError.value = null;

    router.put(
        `/comments/${props.comment.id}`,
        { body },
        {
            // Keep the user's current scroll position after saving the comment.
            preserveScroll: true,

            onStart: () => {
                isSaving.value = true;
            },

            onSuccess: () => {
                isEditing.value = false;
            },

            onError: (errors) => {
                editError.value = errors.body ?? t("comments.update_failed");
            },

            onFinish: () => {
                isSaving.value = false;
            },
        },
    );
};

const deleteComment = () => {
    // Ask the user to confirm deletion.
    const confirmed = window.confirm(t("comments.delete_confirmation"));

    if (!confirmed || isDeleting.value) {
        return;
    }
    // Delete the comment using its ID.
    router.delete(`/comments/${props.comment.id}`, {
        preserveScroll: true,

        onStart: () => {
            isDeleting.value = true;
        },

        onError: (errors) => {
            console.error("Failed to delete comment:", errors);
        },

        onFinish: () => {
            isDeleting.value = false;
        },
    });
};
</script>

<template>
    <div class="flex items-start gap-3 py-3">
        <!-- Comment author's profile photo -->
        <Link :href="userShow(comment.user.username)">
            <div class="avatar">
                <div class="h-10 w-10 rounded-full">
                    <!--Only display the image if the user has a profile photo-->
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

        <div class="min-w-0 flex-1">
            <div class="flex items-center justify-between gap-2">
                <Link
                    :href="userShow(comment.user.username)"
                    class="font-semibold"
                >
                    {{ comment.user.username }}
                </Link>
                <div
                    v-if="comment.user.id === currentUserId"
                    class="flex shrink-0 items-center gap-1"
                >
                    <button
                        type="button"
                        class="btn btn-ghost btn-circle btn-sm tooltip"
                        :data-tip="t('comments.edit')"
                        @click="startEditing"
                    >
                        <Pencil :size="16" />
                    </button>

                    <button
                        type="button"
                        class="btn btn-ghost btn-circle btn-sm tooltip"
                        :data-tip="t('comments.delete')"
                        :disabled="isDeleting || isSaving"
                        @click="deleteComment"
                    >
                        <Trash2 :size="16" />
                    </button>
                </div>
            </div>
            <div v-if="isEditing" class="mt-2 space-y-2">
                <textarea
                    v-model="editedBody"
                    class="textarea textarea-bordered w-full"
                    :disabled="isSaving"
                    maxlength="1000"
                ></textarea>

                <p v-if="editError" class="text-error text-sm">
                    {{ editError }}
                </p>

                <div class="flex gap-2">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        :disabled="isSaving || !editedBody.trim()"
                        @click="saveComment"
                    >
                        {{ t("comments.save") }}
                    </button>

                    <button
                        type="button"
                        class="btn btn-ghost btn-sm"
                        :disabled="isSaving"
                        @click="cancelEditing"
                    >
                        {{ t("comments.cancel") }}
                    </button>
                </div>
            </div>

            <p v-else class="wrap-break-word">
                {{ comment.body }}
            </p>
        </div>
    </div>
</template>
