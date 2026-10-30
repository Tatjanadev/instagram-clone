<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import { ArrowLeft } from "lucide-vue-next";
import PostCard from "@/components/posts/PostCard.vue";
import CommentForm from "@/components/comments/CommentForm.vue";
import CommentList from "@/components/comments/CommentList.vue";
import type { Comment } from "@/types/comment";
import { ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const props = defineProps<{
    post: {
        id: number;
        user_id: number;
        title: string;
        description: string | null;
        likes_count: number;
        is_liked: boolean;
        images: Array<{
            id: number;
            image_path: string;
        }>;
        user: {
            id: number;
            username: string;
            profile_photo_path: string | null;
        };
    };
    comments: Comment[];
    commentsCount: number;
    currentUserId: number;
}>();

const isSubmitting = ref(false);

// Store the validation error returned by Laravel.
const commentError = ref<string | null>(null);

//commentForm holds a reference to CommentForm.vue component, so I can call its clearForm() function.
const commentForm = ref<InstanceType<typeof CommentForm> | null>(null);

const handleCommentSubmit = (body: string) => {
    if (isSubmitting.value) {
        return;
    }

     // Remove any previous error before submitting.
    commentError.value = null;

    router.post(
        `/posts/${props.post.id}/comments`,
        { body },
        {
            preserveScroll: true,

            onStart: () => {
                isSubmitting.value = true;
            },

            onSuccess: () => {
                commentForm.value?.clearForm();
                commentError.value = null;
            },

            onError: (errors) => {
                // Display the validation error from Laravel.
                commentError.value =
                    errors.body ?? t("comments.create_failed");
            },
            //makes the form available again, regardless of whether the request succeeded.
            onFinish: () => {
                isSubmitting.value = false;
            },
        },
    );
};
</script>

<template>
    <div class="flex flex-col items-center p-6">
        <div class="mb-3 flex w-96 items-center gap-3">
            <Link
                href="/posts"
                class="btn btn-circle btn-sm tooltip"
                :data-tip="t('posts.back_to_posts')"
            >
                <ArrowLeft :size="22" />
            </Link>
            <h1 class="text-lg font-semibold">{{ t("posts.post") }}</h1>
        </div>
        <PostCard
            :id="post.id"
            :user-id="post.user_id"
            :current-user-id="currentUserId"
            :username="post.user.username"
            :profile-photo-path="post.user.profile_photo_path"
            :title="post.title"
            :description="post.description"
            :likes-count="post.likes_count"
            :is-liked="post.is_liked"
            :image-path="
                post.images.length
                    ? `/storage/${post.images[0].image_path}`
                    : null
            "
        />
        <!-- Comments section -->
        <div class="mt-6 w-96">
            <h2 class="mb-3 text-lg font-semibold">
                {{ t("comments.title") }} ({{ commentsCount }})
            </h2>

            <!-- This displays all comments -->
            <CommentList 
            :comments="comments" 
            :current-user-id="currentUserId"
            />

            <!-- This displays the form for adding a new comment -->
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
