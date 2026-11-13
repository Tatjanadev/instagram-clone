<script setup lang="ts">
import { Form, Head, usePage } from "@inertiajs/vue3";
import InputError from "@/components/InputError.vue";
import PasswordInput from "@/components/PasswordInput.vue";
import TextLink from "@/components/TextLink.vue";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import { register } from "@/routes";
import { store } from "@/routes/login";
import { request } from "@/routes/password";
import PasskeyVerify from "@/components/PasskeyVerify.vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const page = usePage();

defineOptions({
    layout: {
        title: "Log in to your account",
        description: "Enter your email and password below to log in",
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head :title="t('login.login')" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <PasskeyVerify />

    <div
        v-if="page.props.errors?.google"
        role="alert"
        class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700"
    >
        {{ page.props.errors.google }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email">{{ t("password.email_address") }}</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="border-gray-200 bg-white text-gray-900 placeholder:text-gray-300 dark:bg-white dark:text-gray-900 dark:placeholder:text-gray-300 focus-visible:border-purple-400 focus-visible:ring-purple-200"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password">{{ t("password.password") }}</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-sm !text-purple-700 hover:!text-purple-900"
                        :tabindex="5"
                    >
                        {{ t("login.forgot_your_password") }}
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Password"
                    class="border-gray-200 bg-white text-gray-900 placeholder:text-gray-300 dark:bg-white dark:text-gray-900 dark:placeholder:text-gray-300 focus-visible:border-purple-400 focus-visible:ring-purple-200"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox id="remember" name="remember" :tabindex="3" />
                    <span>{{ t("login.remember_me") }}</span>
                </Label>
            </div>

            <Button
                type="submit"
                class="mt-4 w-full bg-white text-purple-700 shadow-sm ring-1 ring-purple-200 transition-colors duration-200 hover:bg-purple-100 hover:text-purple-700 disabled:opacity-50"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" />
                {{ t("login.login") }}
            </Button>
        </div>

        <div class="text-center text-sm text-gray-600">
            Don't have an account?
            <TextLink
                :href="register()"
                :tabindex="5"
                class="!text-purple-700 hover:!text-purple-900"
                >Sign up</TextLink
            >
        </div>
    </Form>
    <div class="mt-6">
        <a
            href="/auth/google"
            class="flex w-full items-center justify-center gap-3 rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 transition-colors duration-200 hover:border-purple-300 hover:bg-purple-50"
        >
            <img
                src="/images/landing/g-logo.png"
                alt="Google"
                class="h-5 w-5 shrink-0"
            />

            {{ t("social_auth.continue_with_google") }}
        </a>
    </div>
</template>
