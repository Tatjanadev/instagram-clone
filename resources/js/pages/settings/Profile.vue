<script setup lang="ts">
import { Form, Head, usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import ProfileController from "@/actions/App/Http/Controllers/Settings/ProfileController";
import DeleteUser from "@/components/DeleteUser.vue";
import Heading from "@/components/Heading.vue";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { edit } from "@/routes/profile";
import { send } from "@/routes/verification";


defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Profile settings",
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile settings</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Profile"
            description="Update your profile information"
        />

        <Form
            v-bind="ProfileController.update.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="first_name">First name</Label>
                <Input
                    id="first_name"
                    class="mt-1 block w-full"
                    name="first_name"
                    :default-value="user.first_name"
                    required
                    autocomplete="name"
                    placeholder="First name"
                />
                <InputError class="mt-2" :message="errors.first_name" />
            </div>

            <div class="grid gap-2">
                <Label for="last_name">Last name</Label>
                <Input
                    id="last_name"
                    class="mt-1 block w-full"
                    name="last_name"
                    :default-value="user.last_name"
                    required
                    autocomplete="family-name"
                    placeholder="Last name"
                />
                <InputError class="mt-2" :message="errors.last_name" />
            </div>

            <div class="grid gap-2">
                <Label for="username">Username</Label>
                <Input
                    id="username"
                    class="mt-1 block w-full"
                    name="username"
                    :default-value="user.username"
                    required
                    autocomplete="username"
                    placeholder="Username"
                />
                <InputError class="mt-2" :message="errors.username" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    name="email"
                    :default-value="user.email"
                    required
                    autocomplete="username"
                    placeholder="Email address"
                />
                <InputError class="mt-2" :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="bio">Bio</Label>
                <Input
                    id="bio"
                    class="mt-1 block w-full"
                    name="bio"
                    :default-value="user.bio ?? ''"
                    placeholder="Tell us something about yourself"
                />
                <InputError class="mt-2" :message="errors.bio" />
            </div>

            <div class="grid gap-2">
                <Label for="gender">Gender</Label>
                <Input
                    id="gender"
                    class="mt-1 block w-full"
                    name="gender"
                    :default-value="user.gender ?? ''"
                    placeholder="Gender"
                />
                <InputError class="mt-2" :message="errors.gender" />
            </div>

            <div class="grid gap-2">
                <Label for="date_of_birth">Date of birth</Label>
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
                    Your email address is unverified.
                    <Link
                        :href="send()"
                        as="button"
                        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-if="page.props.status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button :disabled="processing" data-test="update-profile-button"
                    >Save</Button
                >
            </div>
        </Form>
    </div>

    <DeleteUser />
</template>
