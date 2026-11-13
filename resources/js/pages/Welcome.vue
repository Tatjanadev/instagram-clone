<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { register } from "@/routes";
import { ArrowRight } from "lucide-vue-next";
import LandingPhotos from "@/components/LandingPhotos.vue";
import LandingLayout from '@/layouts/LandingLayout.vue';
import { useI18n } from "vue-i18n";

const { t } = useI18n();
</script>

<template>
    <Head :title="t('welcome.page_title')" />
    <LandingLayout>
        <main
            class="mx-auto grid min-h-[75vh] w-full max-w-7xl grid-cols-1 items-center gap-12 px-6 py-10 lg:grid-cols-2"
        >
            <div class="max-w-xl">
                <h2 class="text-5xl leading-tight font-bold lg:text-6xl">
                    {{ t("welcome.headline") }}
                </h2>

                <p class="mt-6 text-lg text-gray-600 lg:text-xl">
                    {{ t("welcome.description") }}
                </p>
                <Link
                    v-if="!$page.props.auth.user"
                    :href="register()"
                    class="mt-8 inline-flex items-center justify-center gap-2 rounded-xl bg-fuchsia-500 px-7 py-3 font-semibold text-white transition-colors duration-200 hover:bg-fuchsia-600"
                >
                    {{ t("welcome.get_started") }}
                    <ArrowRight class="size-5 shrink-0 translate-y-0.5" />
                </Link>
            </div>
            <LandingPhotos />
        </main>
    </LandingLayout>
</template>
