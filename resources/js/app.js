import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { defineRule, configure } from 'vee-validate';
import { localize } from '@vee-validate/i18n';
import fr from '@vee-validate/i18n/dist/locale/fr.json';
import Layout from "@/Layouts/Layout";

configure({
    generateMessage: localize({
        fr
    }),
});

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const page = (await import(`./Pages/${name}.vue`)).default;
        page.layout ??= Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        
        app.use(plugin);
        app.component('Head', Head);
        app.component('Link', Link);
        app.mixin({ methods: { route } });
        
        app.mount(el);
    },
    progress: {
        color: '#1FBDEB',
    },
});
