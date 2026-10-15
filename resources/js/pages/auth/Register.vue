<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps<{
    passwordRules: string;
}>();

defineOptions({
    layout: {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
    },
});
</script>

<template>
    <Head :title="t('register.title')" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="first_name">
                    {{ t('register.first_name') }}
                </Label>
                <Input
                    id="first_name"
                    type="text"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="name"
                    name="first_name"
                    :placeholder="t('register.first_name')"
                />
                <InputError :message="errors.first_name" />
            </div>
            <div class="grid gap-2">
                <Label for="last_name">
                    {{ t('register.last_name') }}
                </Label>
                <Input
                    id="last_name"
                    type="text"
                    required
                    :tabindex="2"
                    autocomplete="family-name"
                    name="last_name"
                    :placeholder="t('register.last_name')"
                />
                <InputError :message="errors.last_name" />
            </div>

            <div class="grid gap-2">
                <Label for="username">
                    {{ t('register.username') }}
                </Label>
                <Input
                    id="username"
                    type="text"
                    required
                    :tabindex="3"
                    autocomplete="username"
                    name="username"
                    :placeholder="t('register.username')"
                />
                <InputError :message="errors.username" />
            </div>
            <div class="grid gap-2">
                <Label for="email">
                    {{ t('password.email_address') }}
                </Label>
                <Input
                    id="email"
                    type="email"
                    required
                    :tabindex="4"
                    autocomplete="email"
                    name="email"
                    placeholder="email@example.com"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">
                    {{ t('password.password') }}
                </Label>
                <PasswordInput
                    id="password"
                    required
                    :tabindex="5"
                    autocomplete="new-password"
                    name="password"
                    :placeholder="t('password.password')"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">
                    {{ t('password.confirm_password') }}
                </Label>
                <PasswordInput
                    id="password_confirmation"
                    required
                    :tabindex="6"
                    autocomplete="new-password"
                    name="password_confirmation"
                    :placeholder="t('password.confirm_password')"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-2 w-full"
                tabindex="7"
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" />
                {{ t('register.create_account') }}
            </Button>
        </div>

        <
        <div class="text-muted-foreground text-center text-sm">
            {{ t('register.already_have_account') }}
            <TextLink
                :href="login()"
                class="underline underline-offset-4"
                :tabindex="8"
            >
                {{ t('login.login') }}
            </TextLink>
        </div>
    </Form>
</template>
