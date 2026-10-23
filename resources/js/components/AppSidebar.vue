<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import { CirclePlus, UserRoundSearch, UserStar } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
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

const { t } = useI18n();

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
            <LanguageSwitcher />
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
