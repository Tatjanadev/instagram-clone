<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

interface Props {
    googleName: string;
    email: string;
    usernameSuggestions: string[];
}

const props = defineProps<Props>();

const nameParts = props.googleName.trim().split(/\s+/);

const firstName = nameParts.shift() ?? "";
const lastName = nameParts.join(" ");

const form = useForm({
    first_name: firstName,
    last_name: lastName,
    username: props.usernameSuggestions[0] ?? "",
});

const submit = () => {
    form.post("/auth/google/complete");
};
</script>

<template>
    <main class="mx-auto max-w-md p-6">
        <h1 class="mb-2 text-2xl font-bold">
            {{ t("social_auth.complete_profile_title") }}
        </h1>

        <p class="mb-6 text-gray-600">
            {{ t("social_auth.complete_profile_description") }}
        </p>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label for="first_name">{{
                    t("social_auth.first_name")
                }}</label>
                <input
                    id="first_name"
                    v-model="form.first_name"
                    type="text"
                    class="w-full rounded border p-2"
                />
                <p
                    v-if="form.errors.first_name"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.first_name }}
                </p>
            </div>

            <div>
                <label for="last_name">{{ t("social_auth.last_name") }}</label>
                <input
                    id="last_name"
                    v-model="form.last_name"
                    type="text"
                    class="w-full rounded border p-2"
                />
                <p
                    v-if="form.errors.last_name"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.last_name }}
                </p>
            </div>

            <div>
                <label for="username">{{ t("social_auth.username") }}</label>
                <input
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="w-full rounded border p-2"
                />
                <p
                    v-if="form.errors.username"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.username }}
                </p>
            </div>

            <div>
                <p class="mb-2 text-sm">
                    {{ t("social_auth.suggested_usernames") }}:
                </p>

                <div class="flex flex-wrap gap-2">
                    <button
                        v-for="suggestion in props.usernameSuggestions"
                        :key="suggestion"
                        type="button"
                        class="rounded-full border px-3 py-1 text-sm"
                        @click="form.username = suggestion"
                    >
                        {{ suggestion }}
                    </button>
                </div>
            </div>

            <p class="text-sm text-gray-600">
                {{ t("social_auth.google_email") }}: {{ props.email }}
            </p>
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full rounded bg-blue-600 px-4 py-2 text-white disabled:opacity-50"
            >
                {{
                    form.processing
                        ? t("social_auth.creating_account")
                        : t("social_auth.continue")
                }}
            </button>
        </form>
    </main>
</template>
