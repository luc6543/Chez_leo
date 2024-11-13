import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({command, mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    return {
        define: {
            __SENTRY_RELEASE_VERSION__: JSON.stringify(env.SENTRY_RELEASE_VERSION) ?? null,
        }, resolve: {
            alias: {
                '@': '/resources/js', 'spatie-media-lib-pro': '/vendor/spatie/laravel-medialibrary-pro/resources/js',
            },
        },server: {
            host: true,
            strictPort: true,
            port: 5173,
            hmr: {
                protocol: 'wss',
                host: `${process.env.DDEV_HOSTNAME}`,
            },
            watch: {
                ignored: ["**/vendor/**", '**/storage/**'],
            },
        }, plugins: [laravel({
            input: ['resources/js/app.js','resources/css/app.css'], refresh: true,
        }),],
    };
});
