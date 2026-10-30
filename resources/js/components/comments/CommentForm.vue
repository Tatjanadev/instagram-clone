<script setup lang="ts">
import { ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

defineProps<{
    isSubmitting: boolean;
    error: string | null;
}>();

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
};

//Its only job is to empty the comment input.
const clearForm = () => {
    body.value = "";
};

//Allow my parent component to call this particular function
defineExpose({
    clearForm,
});
</script>

<template>
    <!--The .prevent stops the browser from reloading the page.-->
    <form @submit.prevent="submitComment" class="space-y-2">
        <div class="flex items-center gap-2">
            <input
                v-model="body"
                type="text"
                :placeholder="t('comments.write_comment')"
                :disabled="isSubmitting"
                class="input input-bordered min-w-0 flex-1"
                maxlength="1000"
            />

            <button
                type="submit"
                class="btn btn-primary"
                :disabled="isSubmitting || !body.trim()"
            >
                {{ t("comments.submit") }}
            </button>
        </div>
         <!-- Display validation error underneath the input. -->
        <p v-if="error" class="text-error text-sm">
            {{ error }}
        </p>
    </form>
</template>
