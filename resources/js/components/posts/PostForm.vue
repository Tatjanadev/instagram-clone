<script setup lang="ts">
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    description: "",
    images: [] as File[],
});

const imagePreviews = computed(() =>
    form.images.map((image) => URL.createObjectURL(image)),
);

const submit = () => {
    form.post("/posts", {
        forceFormData: true,
    });
};

const handleImages = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files) {
        form.images = Array.from(target.files);
    }
};
</script>

<template>
    <form
        class="card bg-base-100 w-full max-w-xl shadow-sm"
        @submit.prevent="submit"
    >
        <figure class="p-4">
            <div class="form-control w-full">
                <label class="label" for="images">
                    <span class="label-text">Images</span>
                </label>

                <input
                    id="images"
                    name="images[]"
                    type="file"
                    class="file-input file-input-bordered w-full"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    required
                    @change="handleImages"
                />

                <p v-if="form.errors.images" class="text-error text-sm">
                    {{ form.errors.images }}
                </p>

                <div
                    v-if="imagePreviews.length"
                    class="mt-4 grid grid-cols-2 gap-3"
                >
                    <img
                        v-for="(preview, index) in imagePreviews"
                        :key="index"
                        :src="preview"
                        alt="Selected post image"
                        class="h-40 w-full rounded-lg object-cover"
                    />
                </div>
            </div>
        </figure>

        <div class="card-body">
            <div class="form-control">
                <label class="label" for="title">
                    <span class="label-text">Title</span>
                </label>

                <input
                    id="title"
                    name="title"
                    type="text"
                    class="input input-bordered w-full"
                    placeholder="Write a title"
                    required
                    v-model="form.title"
                />

                <p v-if="form.errors.title" class="text-error text-sm">
                    {{ form.errors.title }}
                </p>
            </div>

            <div class="form-control">
                <label class="label" for="description">
                    <span class="label-text">Description</span>
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="textarea textarea-bordered w-full"
                    placeholder="Write a description"
                    rows="4"
                    v-model="form.description"
                ></textarea>

                <p v-if="form.errors.description" class="text-error text-sm">
                    {{ form.errors.description }}
                </p>
            </div>

            <div class="card-actions justify-end">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Creating..." : "Create Post" }}
                </button>
            </div>
        </div>
    </form>
</template>