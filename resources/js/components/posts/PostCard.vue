<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';
import { show as userShow } from '@/routes/users';

const props = defineProps<{
    id: number;
    userId: number;
    currentUserId: number;
    username: string;
    profilePhotoPath: string | null;
    title: string;
    description: string | null;
    imagePath: string | null;
}>();
const deletePost = () => {
    const confirmed = window.confirm(
        'Are you sure you want to delete this post?',
    );
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
                        alt="Profile photo"
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
                data-tip="Like"
            >
                <Heart :size="22" />
            </button>

            <Link
                v-if="userId === currentUserId"
                :href="`/posts/${id}/edit`"
                class="btn btn-sm btn-accent"
            >
                Edit
            </Link>

            <button
                v-if="userId === currentUserId"
                type="button"
                class="btn btn-sm btn-error"
                @click="deletePost"
            >
                Delete
            </button>
        </div>
    </div>
</template>
