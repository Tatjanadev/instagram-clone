<script setup lang="ts">
defineProps<{
    title: string;
    description: string | null;
    imagePath: string | null;
}>();
</script>

<template>
    <div class="card bg-base-100 w-96 shadow-sm">
        <figure v-if="imagePath">
            <img
                :src="imagePath"
                :alt="title"
            />
        </figure>

        <div class="card-body">
            <h2 class="card-title">
                {{ title }}
            </h2>

            <p v-if="description">
                {{ description }}
            </p>

            <div class="card-actions justify-end">
                <button class="btn btn-primary">
                    Like
                </button>
            </div>
        </div>
    </div>
</template>