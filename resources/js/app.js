import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import 'flowbite';
import Layout from "@/Layouts/Layout";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => { //global layout into all page website
        let page = ( await import(`./Pages/${name}.vue`)).default;

        page.layout ??= Layout;

        return page;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .component("Link", Link)
            .component("Head", Head)
            .use(ElementPlus)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#ff5470' });
