<script setup lang="ts">
import { useI18n } from "vue-i18n";

const { t } = useI18n();
</script>

<template>
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
</template>
