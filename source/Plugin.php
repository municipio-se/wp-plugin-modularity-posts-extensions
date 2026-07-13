<?php

declare(strict_types=1);

namespace MunicipioModularityPosts;

final class Plugin
{
    private const POSTS_FIELD_KEY = 'field_571dfd4c0d9d9';

    public function register(): void
    {
        add_action('init', [$this, 'loadTextDomain'], -10);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);

        add_action('acf/render_field/key=' . self::POSTS_FIELD_KEY, [Fields::class, 'renderMixedChoice'], 10);

        /**
         * Municipio resolves the final Blade name after preparing the selected layout data. The
         * built-in list preparation is the compatible 6.43.2 contract for both cards and links.
         */
        add_filter('Modularity/Module/Posts/template', [$this, 'routeTemplate'], 10, 4);

        /**
         * Modularity resolves the template filename before it initializes Blade. This path hook
         * makes the plugin-owned mixed view discoverable during that first lookup.
         */
        add_filter('Modularity/Module/posts/TemplatePath', [$this, 'registerTemplatePaths']);

        /**
         * Once the template is found, Blade needs both the built-in Posts views and the plugin
         * view root: the plugin owns the mixed composition while Municipio continues to own card,
         * collection, and title partials.
         */
        add_filter('/Modularity/externalViewPath', [$this, 'registerViewPaths']);
    }

    public function loadTextDomain(): void
    {
        load_plugin_textdomain('modularity-posts', false, 'modularity-posts/languages');
    }

    public function enqueueStyles(): void
    {
        wp_enqueue_style(
            'modularity-posts',
            MODULARITY_POSTS_URL . 'assets/css/mixed.css',
            [],
            MODULARITY_POSTS_VERSION,
        );
    }

    /**
     * @param array<int, string> $paths
     * @return array<int, string>
     */
    public function registerTemplatePaths(array $paths): array
    {
        $paths[] = MODULARITY_POSTS_PATH . 'views';

        return array_values(array_unique($paths));
    }

    /**
     * @param array<string, string|array<int, string>> $paths
     * @return array<string, string|array<int, string>>
     */
    public function registerViewPaths(array $paths): array
    {
        $postsPaths = $paths['mod-posts'] ?? [];
        $postsPaths = is_array($postsPaths) ? $postsPaths : [$postsPaths];

        if (defined('MODULARITY_PATH')) {
            $postsPaths[] = MODULARITY_PATH . 'source/php/Module/Posts/views';
        }

        $postsPaths[] = MODULARITY_POSTS_PATH . 'views';
        $paths['mod-posts'] = array_values(array_unique(array_filter($postsPaths, 'is_string')));

        return $paths;
    }

    /**
     * @param object{data: array<string, mixed>} $module
     * @param array<string, mixed> $data
     * @param array<string, mixed> $fields
     */
    public function routeTemplate(string $template, object $module, array $data, array $fields): string
    {
        if (($fields['posts_display_as'] ?? null) !== 'mixed') {
            return $template;
        }

        $posts = $data['posts'] ?? [];
        $partition = MixedLayout::partition(is_array($posts) ? $posts : []);

        $module->data['mixedCards'] = $partition['cards'];
        $module->data['mixedList'] = $partition['list'];
        $module->data['showDate'] = in_array('date', $fields['posts_fields'] ?? [], true);

        return 'mixed.blade.php';
    }
}
