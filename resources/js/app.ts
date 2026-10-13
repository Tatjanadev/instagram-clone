import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';
import en from '@/locales/en.json';
import nb from '@/locales/nb.json';
import cy from '@/locales/cy.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const i18n = createI18n({
    legacy: false,
    locale:  localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages: {
        en,
        nb,
        cy,
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
