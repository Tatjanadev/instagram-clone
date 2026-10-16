<script setup lang="ts">
import { Form, Head, usePage, setLayoutProps } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { computed, watchEffect } from 'vue';
import { useI18n } from 'vue-i18n';
import UserController from '@/actions/App/Http/Controllers/Settings/UserController';
import DeleteUser from '@/components/DeleteUser.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit } from '@/routes/user';
import { send } from '@/routes/verification';
import { show as profileShow } from '@/routes/profile';

const { t } = useI18n();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile settings',
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);

watchEffect(() => {
    setLayoutProps({
        breadcrumbs: [
            {
                title: t('profile.settings_title'),
                href: edit(),
            },
        ],
    });
});
</script>

<template>
    <Head :title="t('profile.settings_title')" />

    <h1 class="sr-only">{{ t('profile.settings_title') }}</h1>

    <div class="flex flex-col space-y-6">
        <Link :href="profileShow()" class="btn btn-ghost w-fit">
            {{ t('profile.back_to_profile') }}
        </Link>
        <Heading
            variant="small"
            :title="t('profile.profile')"
            :description="t('profile.update_description')"
        />

        <Form
            v-bind="UserController.update.form()"
            method="post"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="profile_photo">
                    {{ t('profile.profile_photo') }}</Label
                >

                <div v-if="user.profile_photo_path" class="avatar mb-2">
                    <div class="w-20 rounded-full">
                        <img
                            :src="`/storage/${user.profile_photo_path}`"
                            :alt="t('profile.current_profile_photo')"
                        />
                    </div>
                </div>

                <Input
                    id="profile_photo"
                    type="file"
                    name="profile_photo"
                    accept="image/*"
                />

                <InputError class="mt-2" :message="errors.profile_photo" />
            </div>
            <div class="grid gap-2">
                <Label for="first_name">{{ t('profile.first_name') }}</Label>
                <Input
                    id="first_name"
                    class="mt-1 block w-full"
                    name="first_name"
                    :default-value="user.first_name"
                    required
                    autocomplete="name"
                    :placeholder="t('profile.first_name')"
                />
                <InputError class="mt-2" :message="errors.first_name" />
            </div>

            <div class="grid gap-2">
                <Label for="last_name">{{ t('profile.last_name') }}</Label>
                <Input
                    id="last_name"
                    class="mt-1 block w-full"
                    name="last_name"
                    :default-value="user.last_name"
                    required
                    autocomplete="family-name"
                    :placeholder="t('profile.last_name')"
                />
                <InputError class="mt-2" :message="errors.last_name" />
            </div>

            <div class="grid gap-2">
                <Label for="username"> {{ t('profile.username') }}</Label>
                <Input
                    id="username"
                    class="mt-1 block w-full"
                    name="username"
                    :default-value="user.username"
                    required
                    autocomplete="username"
                    :placeholder="t('profile.username')"
                />
                <InputError class="mt-2" :message="errors.username" />
            </div>

            <div class="grid gap-2">
                <Label for="email"> {{ t('profile.email_address') }}</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    name="email"
                    :default-value="user.email"
                    required
                    autocomplete="username"
                    :placeholder="t('profile.email_address')"
                />
                <InputError class="mt-2" :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="bio">{{ t('profile.bio') }}</Label>
                <Input
                    id="bio"
                    class="mt-1 block w-full"
                    name="bio"
                    :default-value="user.bio ?? ''"
                    :placeholder="t('profile.bio_placeholder')"
                />
                <InputError class="mt-2" :message="errors.bio" />
            </div>

            <div class="grid gap-2">
                <Label for="gender">{{ t('profile.gender') }}</Label>
                <Input
                    id="gender"
                    class="mt-1 block w-full"
                    name="gender"
                    :default-value="user.gender ?? ''"
                    :placeholder="t('profile.gender')"
                />
                <InputError class="mt-2" :message="errors.gender" />
            </div>

            <div class="grid gap-2">
                <Label for="date_of_birth">{{
                    t('profile.date_of_birth')
                }}</Label>
                <Input
                    id="date_of_birth"
                    type="date"
                    class="mt-1 block w-full"
                    name="date_of_birth"
                    :default-value="user.date_of_birth ?? ''"
                />
                <InputError class="mt-2" :message="errors.date_of_birth" />
            </div>

            <div v-if="page.props.mustVerifyEmail && !user.email_verified_at">
                <p class="text-muted-foreground -mt-4 text-sm">
                    {{ t('profile.email_unverified') }}
                    <Link
                        :href="send()"
                        as="button"
                        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                    >
                        {{ t('profile.resend_verification') }}
                    </Link>
                </p>

                <div
                    v-if="page.props.status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    {{ t('profile.verification_sent') }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button
                    :disabled="processing"
                    data-test="update-profile-button"
                >
                    {{ t('profile.save') }}</Button
                >
            </div>
        </Form>
    </div>

    <DeleteUser />
</template>
