<script setup lang="ts">
import LandingLayout from "@/layouts/LandingLayout.vue";
import LandingPhotos from "@/components/LandingPhotos.vue";

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <LandingLayout>
        <main
            class="mx-auto grid min-h-[75vh] w-full max-w-7xl grid-cols-1 items-center gap-12 px-6 py-10 lg:grid-cols-2"
        >
            <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
                <div class="flex flex-col gap-6">
                    <div class="space-y-2 text-center">
                        <h1 class="text-2xl font-semibold">
                            {{ title }}
                        </h1>

                        <p class="text-sm text-gray-600">
                            {{ description }}
                        </p>
                    </div>

                    <slot />
                </div>
            </div>

            <LandingPhotos />
        </main>
    </LandingLayout>
</template>
