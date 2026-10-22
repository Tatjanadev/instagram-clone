<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login } from '@/routes';
import { register } from '@/routes';
import { show as profileShow } from '@/routes/profile';
import AppLogo from '@/components/AppLogo.vue';
import { ArrowRight } from 'lucide-vue-next';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
    <Head :title="t('welcome.page_title')" />

    <div
        class="min-h-screen bg-linear-to-br from-pink-50 via-purple-50 to-fuchsia-100 text-gray-900"
    >
        <header
            class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-5"
        >
            <AppLogo class="origin-left scale-150" />

            <nav class="flex items-center gap-3">
                <LanguageSwitcher />
                <Link
                    v-if="$page.props.auth.user"
                    :href="profileShow()"
                    class="rounded-lg bg-gray-900 px-5 py-2 text-white hover:bg-gray-700"
                >
                    {{ t('welcome.profile') }}
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-lg px-5 py-2 font-medium transition-colors duration-200 hover:bg-purple-100 hover:text-purple-700"
                    >
                        {{ t('login.login') }}
                    </Link>

                    <Link
                        :href="register()"
                        class="rounded-lg px-5 py-2 font-medium transition-colors duration-200 hover:bg-purple-100 hover:text-purple-700"
                    >
                        {{ t('register.register') }}
                    </Link>
                </template>
            </nav>
        </header>

        <main
            class="mx-auto grid min-h-[75vh] w-full max-w-7xl grid-cols-1 items-center gap-12 px-6 py-10 lg:grid-cols-2"
        >
            <div class="max-w-xl">
                <h2 class="text-5xl leading-tight font-bold lg:text-6xl">
                    {{ t('welcome.headline') }}
                </h2>

                <p class="mt-6 text-lg text-gray-600 lg:text-xl">
                    {{ t('welcome.description') }}
                </p>
                <Link
                    v-if="!$page.props.auth.user"
                    :href="register()"
                    class="mt-8 inline-flex items-center justify-center gap-2 rounded-xl bg-fuchsia-500 px-7 py-3 font-semibold text-white transition-colors duration-200 hover:bg-fuchsia-600"
                >
                    {{ t('welcome.get_started') }}
                    <ArrowRight class="size-5 shrink-0 translate-y-0.5" />
                </Link>
            </div>
            <div class="grid grid-cols-2 items-center gap-4">
                <img
                    src="/images/landing/photo1.jpg"
                    :alt="t('welcome.photo_firends')"
                    class="h-64 w-full -rotate-3 rounded-2xl object-cover shadow-xl transition-transform duration-300 hover:scale-105 hover:rotate-0"
                />

                <img
                    src="/images/landing/photo2.jpg"
                    :alt="t('welcome.photo_travel')"
                    class="h-72 w-full rotate-3 rounded-2xl object-cover shadow-xl transition-transform duration-300 hover:scale-105 hover:rotate-0"
                />

                <img
                    src="/images/landing/photo3.jpg"
                    :alt="t('welcome.photo_coffee')"
                    class="col-span-2 h-48 w-full rounded-2xl object-cover shadow-xl transition-transform duration-300 hover:scale-105"
                />
            </div>
        </main>
    </div>
</template>
