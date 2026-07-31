// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
    integrations: [starlight({
        title: 'OSPOS Docs',
        logo: {
            src: './src/assets/logo.svg',
            replacesTitle: true,
        },
        social: [
            { icon: 'matrix', label: 'Matrix', href: 'https://matrix.to/#/#opensourcepos_Lobby:gitter.im' },
            { icon: 'github', label: 'GitHub', href: 'https://github.com/opensourcepos/opensourcepos' }
        ],
        sidebar: [
            {
                label: 'Getting Started',
                items: [{ autogenerate: { directory: 'getting-started' } }],
            },
            {
                label: 'Guides',
                items: [{ autogenerate: { directory: 'guides' } }],
            },
            {
                label: 'Reference',
                items: [{ autogenerate: { directory: 'reference' } }],
            },
        ],
        editLink: {
            baseUrl: 'https://github.com/opensourcepos/opensourcepos/edit/gh-pages/',
        },
    })],
});