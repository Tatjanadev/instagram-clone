<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { login, register } from "@/routes";
import { show as profileShow } from "@/routes/profile";
import AppLogo from "@/components/AppLogo.vue";
import LanguageSwitcher from "@/components/LanguageSwitcher.vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
</script>

<template>
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
                    {{ t("welcome.profile") }}
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-lg px-5 py-2 font-medium transition-colors duration-200 hover:bg-purple-100 hover:text-purple-700"
                    >
                        {{ t("login.login") }}
                    </Link>

                    <Link
                        :href="register()"
                        class="rounded-lg px-5 py-2 font-medium transition-colors duration-200 hover:bg-purple-100 hover:text-purple-700"
                    >
                        {{ t("register.register") }}
                    </Link>
                </template>
            </nav>
        </header>

        <slot />
    </div>
</template>
