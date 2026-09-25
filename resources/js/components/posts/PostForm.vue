<script setup lang="ts">
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    post?: {
        id: number;
        title: string;
        description: string | null;
        images: Array<{
            id: number;
            image_path: string;
        }>;
    };
}>();

const isEditing = computed(() => !!props.post);

const form = useForm({
    title: props.post?.title ?? "",
    description: props.post?.description ?? "",
    images: [] as File[],
});

const imagePreviews = computed(() =>
    form.images.map((image) => URL.createObjectURL(image)),
);

const handleImages = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files) {
        form.images = Array.from(target.files);
    }
};

//Decide whether this form is for creating a new post or editing an existing one
const submit = () => {
    if (isEditing.value && props.post) {
        // Do not submit if nothing was changed
        if (!form.isDirty) {
            return;
        }

        form.patch(`/posts/${props.post.id}`);
    } else {
        form.post("/posts", {
            forceFormData: true,
        });
    }
};
</script>

<template>
    <form
        class="card bg-base-100 w-full max-w-xl shadow-sm"
        @submit.prevent="submit"
    >
        <!-- Display existing images when editing -->
        <div v-if="isEditing && post?.images.length" class="space-y-2">
            <figure v-for="image in post.images" :key="image.id">
                <img :src="`/storage/${image.image_path}`" :alt="post.title" />
            </figure>
        </div>

        <!--
            CREATE MODE:
            Let the user choose new images.
        -->
        <figure v-if="!isEditing" class="flex flex-col gap-3 p-4">
            <input
                type="file"
                accept="image/jpeg,image/png,image/webp"
                multiple
                class="file-input file-input-bordered w-full"
                @change="handleImages"
            />

            <!-- Preview newly selected images -->
            <img
                v-for="(preview, index) in imagePreviews"
                :key="index"
                :src="preview"
                alt="Selected image preview"
                class="rounded-lg"
            />
        </figure>

        <div class="card-body">
            <!-- Existing images when editing -->
            <div v-if="isEditing && post?.images.length" class="mb-4">
                <p class="mb-2 font-semibold">Current images</p>

                <div class="flex flex-wrap gap-3">
                    <img
                        v-for="image in post.images"
                        :key="image.id"
                        :src="`/storage/${image.image_path}`"
                        :alt="post.title"
                        class="h-32 w-32 rounded-lg object-cover"
                    />
                </div>
            </div>
            <!-- Title -->
            <input
                v-model="form.title"
                type="text"
                class="input input-bordered w-full"
                placeholder="Post title"
            />

            <p v-if="form.errors.title" class="text-sm text-error">
                {{ form.errors.title }}
            </p>

            <!-- Description -->
            <textarea
                v-model="form.description"
                class="textarea textarea-bordered w-full"
                placeholder="Description"
            ></textarea>

            <p v-if="form.errors.description" class="text-sm text-error">
                {{ form.errors.description }}
            </p>

            <!-- Image validation error -->
            <p v-if="form.errors.images" class="text-sm text-error">
                {{ form.errors.images }}
            </p>

            <div class="card-actions flex-col items-end justify-end">
                <p v-if="isEditing && !form.isDirty" class="text-sm opacity-60">
                    Make a change before saving.
                </p>
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing || (isEditing && !form.isDirty)"
                >
                    {{
                        form.processing
                            ? "Saving..."
                            : isEditing
                              ? "Save changes"
                              : "Create post"
                    }}
                </button>
            </div>
        </div>
    </form>
</template>
