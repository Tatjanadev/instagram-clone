<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import { CirclePlus, UserRoundSearch, UserStar } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { index as usersIndex } from '@/routes/users';
import { create as postCreate } from '@/routes/posts';
import { show as profileShow } from '@/routes/profile';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import type { NavItem } from '@/types';

const { t, locale } = useI18n();

type Language = 'en' | 'nb' | 'cy';

function changeLanguage(language: Language) {
    // Change the language immediately in Vue.
    locale.value = language;

    // Remember the selected language in the browser.
    localStorage.setItem('locale', language);

    // Also save the language in Laravel's session for backend translations.
    router.post(`/language/${language}`);
}

const mainNavItems = computed<NavItem[]>(() => [
    {
        title: t('navigation.users'),
        href: usersIndex(),
        icon: UserRoundSearch,
    },
    {
        title: t('navigation.create_post'),
        href: postCreate(),
        icon: CirclePlus,
    },
    {
        title: t('navigation.my_profile'),
        href: profileShow(),
        icon: UserStar,
    },
]);

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="profileShow()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <div class="flex gap-2 px-2">
                <button
                    :class="{ 'font-bold underline': locale === 'en' }"
                    @click="changeLanguage('en')"
                >
                    EN
                </button>

                <button
                    :class="{ 'font-bold underline': locale === 'nb' }"
                    @click="changeLanguage('nb')"
                >
                    NO
                </button>

                <button
                    :class="{ 'font-bold underline': locale === 'cy' }"
                    @click="changeLanguage('cy')"
                >
                    CY
                </button>
            </div>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
