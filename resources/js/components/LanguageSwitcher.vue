<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

type Language = "en" | "nb" | "cy";

function changeLanguage(language: Language) {
    // Change the language immediately in Vue.
    locale.value = language;

    // Remember the selected language in the browser.
    localStorage.setItem("locale", language);

    // Also save the language in Laravel's session for backend translations.
    router.post(`/language/${language}`);
}
</script>

<template>
    <div class="flex gap-2 px-2">
        <button
            type="button"
            :class="{ 'font-bold underline': locale === 'en' }"
            @click="changeLanguage('en')"
        >
            EN
        </button>

        <button
            type="button"
            :class="{ 'font-bold underline': locale === 'nb' }"
            @click="changeLanguage('nb')"
        >
            NO
        </button>

        <button
            type="button"
            :class="{ 'font-bold underline': locale === 'cy' }"
            @click="changeLanguage('cy')"
        >
            CY
        </button>
    </div>
</template>
