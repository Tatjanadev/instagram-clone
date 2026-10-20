<script setup lang="ts">
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

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

// If a post prop is passed, we are editing an existing post;
// otherwise, we are creating a new one.
const isEditing = computed(() => !!props.post);

// When editing, use the existing post data to populate the form fields.
// Otherwise, use empty values for a new post.
const form = useForm({
    title: props.post?.title ?? '',
    description: props.post?.description ?? '',
    images: [] as File[],
    deleted_image_ids: [] as number[],
});

// Create temporary URLs so selected images can be previewed.
const imagePreviews = computed(() =>
    form.images.map((image) => URL.createObjectURL(image)),
);

// Put selected files into form.images.
const handleImages = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files) {
        form.images.push(...Array.from(target.files));
        target.value = '';
    }
};

// Mark an existing image for deletion.
const removeImage = (imageId: number) => {
    form.deleted_image_ids.push(imageId);
};

// Decide whether this form is creating a new post
// or editing an existing one.
const submit = () => {
    if (isEditing.value && props.post) {
        // Do not submit if nothing was changed.
        if (!form.isDirty) {
            return;
        }

        // Send as POST FormData, but tell Laravel to treat it as PATCH.
        form.transform((data) => {
            return {
                ...data,
                _method: 'PATCH',
            };
        }).post(`/posts/${props.post.id}`, {
            forceFormData: true,
        });
    } else {
        form.post('/posts', {
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
        <div class="card-body">
            <!-- Display existing images when editing -->
            <div v-if="isEditing && post?.images.length" class="mb-4">
                <p class="mb-2 font-semibold">
                    {{ t('posts.current_images') }}
                </p>

                <div class="flex flex-wrap gap-3">
                    <div
                        v-for="image in post.images"
                        :key="image.id"
                        class="relative"
                    >
                        <!-- Show this image only if its ID is NOT in the list of images selected for deletion. -->
                        <template
                            v-if="!form.deleted_image_ids.includes(image.id)"
                        >
                            <img
                                :src="`/storage/${image.image_path}`"
                                :alt="post.title"
                                class="h-32 w-32 rounded-lg object-cover"
                            />

                            <button
                                type="button"
                                class="btn btn-error btn-circle btn-xs absolute top-1 right-1"
                                :aria-label="t('posts.remove_image')"
                                @click="removeImage(image.id)"
                            >
                                ×
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Image picker works for both Create and Edit -->
            <div class="mb-4">
                <p class="mb-2 font-semibold">
                    {{
                        isEditing
                            ? t('posts.add_images')
                            : t('posts.choose_images')
                    }}
                </p>

                <input
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    class="file-input file-input-bordered w-full"
                    @change="handleImages"
                />

                <p v-if="isEditing" class="mt-2 text-sm opacity-60">
                    {{ t('posts.keep_current_images') }}
                </p>
            </div>

            <!-- Preview newly selected images -->
            <div v-if="imagePreviews.length" class="mb-4">
                <p class="mb-2 font-semibold">
                    {{ isEditing ? t('posts.new_images') : t('posts.preview') }}
                </p>

                <div class="flex flex-wrap gap-3">
                    <img
                        v-for="(preview, index) in imagePreviews"
                        :key="index"
                        :src="preview"
                        :alt="t('posts.selected_image_preview')"
                        class="h-32 w-32 rounded-lg object-cover"
                    />
                </div>
            </div>

            <!-- Title -->
            <input
                v-model="form.title"
                type="text"
                class="input input-bordered w-full"
                :placeholder="t('posts.post_title')"
            />

            <p v-if="form.errors.title" class="text-error text-sm">
                {{ form.errors.title }}
            </p>

            <!-- Description -->
            <textarea
                v-model="form.description"
                class="textarea textarea-bordered w-full"
                :placeholder="t('posts.description')"
            ></textarea>

            <p v-if="form.errors.description" class="text-error text-sm">
                {{ form.errors.description }}
            </p>

            <!-- Image validation error -->
            <p v-if="form.errors.images" class="text-error text-sm">
                {{ form.errors.images }}
            </p>

            <div class="card-actions flex-col items-end justify-end">
                <p v-if="isEditing && !form.isDirty" class="text-sm opacity-60">
                    {{ t('posts.make_change') }}
                </p>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing || (isEditing && !form.isDirty)"
                >
                    {{
                        form.processing
                            ? t('posts.saving')
                            : isEditing
                              ? t('posts.save_changes')
                              : t('posts.create_post')
                    }}
                </button>
            </div>
        </div>
    </form>
</template>
