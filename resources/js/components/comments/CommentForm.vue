<script setup lang="ts">
import { ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const emit = defineEmits<{
    submit: [body: string];
}>();

const body = ref("");

const submitComment = () => {
    const comment = body.value.trim();

    if (!comment) {
        return;
    }

    emit("submit", comment);
    body.value = "";
};
</script>

<template>
    //The .prevent stops the browser from reloading the page.
    <form @submit.prevent="submitComment" class="flex items-center gap-2">
        <input
            v-model="body"
            type="text"
            :placeholder="t('comments.write_comment')"
            class="input input-bordered flex-1"
            maxlength="1000"
        />

        <button type="submit" class="btn btn-primary" :disabled="!body.trim()">
            {{ t("comments.submit") }}
        </button>
    </form>
</template>
