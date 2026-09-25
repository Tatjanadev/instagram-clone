<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import { Heart } from "lucide-vue-next";

const props = defineProps<{
    id: number;
    userId: number;
    currentUserId: number;
    title: string;
    description: string | null;
    imagePath: string | null;
}>();
const deletePost = () => {
    router.delete(`/posts/${props.id}`);
};
</script>

<template>
    <div class="card bg-base-100 w-96 shadow-sm">
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
