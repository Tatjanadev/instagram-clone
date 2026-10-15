import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';
import enNavigation from '@/locales/en/navigation.json';
import nbNavigation from '@/locales/nb/navigation.json';
import cyNavigation from '@/locales/cy/navigation.json';
import enErrors from '@/locales/en/errors.json';
import nbErrors from '@/locales/nb/errors.json';
import cyErrors from '@/locales/cy/errors.json';
import enAppearance from '@/locales/en/appearance.json';
import nbAppearance from '@/locales/nb/appearance.json';
import cyAppearance from '@/locales/cy/appearance.json';
import enDeleteUser from '@/locales/en/deleteUser.json';
import nbDeleteUser from '@/locales/nb/deleteUser.json';
import cyDeleteUser from '@/locales/cy/deleteUser.json';
import enManagePasskeys from '@/locales/en/managePasskeys.json';
import nbManagePasskeys from '@/locales/nb/managePasskeys.json';
import cyManagePasskeys from '@/locales/cy/managePasskeys.json';
import enTwoFactor from '@/locales/en/twoFactor.json';
import nbTwoFactor from '@/locales/nb/twoFactor.json';
import cyTwoFactor from '@/locales/cy/twoFactor.json';
import enPassword from '@/locales/en/password.json';
import nbPassword from '@/locales/nb/password.json';
import cyPassword from '@/locales/cy/password.json';
import enUserMenu from '@/locales/en/userMenu.json';
import cyUserMenu from '@/locales/cy/userMenu.json';
import nbUserMenu from '@/locales/nb/userMenu.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages: {
        en: {
            navigation: enNavigation,
            errors: enErrors,
            appearance: enAppearance,
            deleteUser: enDeleteUser,
            managePasskeys: enManagePasskeys,
            twoFactor: enTwoFactor,
            password: enPassword,
            userMenu: enUserMenu,
        },
        nb: {
            navigation: nbNavigation,
            errors: nbErrors,
            appearance: nbAppearance,
            deleteUser: nbDeleteUser,
            managePasskeys: nbManagePasskeys,
            twoFactor: nbTwoFactor,
            password: nbPassword,
            userMenu: cyUserMenu,
        },
        cy: {
            navigation: cyNavigation,
            errors: cyErrors,
            appearance: cyAppearance,
            deleteUser: cyDeleteUser,
            managePasskeys: cyManagePasskeys,
            twoFactor: cyTwoFactor,
            password: cyPassword,
            userMenu: nbUserMenu,
        },
    },
});

void createInertiaApp({
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({
            render: () => h(App, props),
        });

        vueApp.use(plugin);
        vueApp.use(i18n);

        vueApp.mount(el!);
    },
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
            case name === 'usersEdit':
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
