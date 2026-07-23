<?php

/**
 * Minimal stand-ins for the WordPress and Modularity classes the mixed route touches at
 * render time. The ListTemplate stub mirrors the real controller's observable contract:
 * constructed with the module, it exposes decorated posts on `data['posts']`.
 */

declare(strict_types=1);

namespace {
    class WP_Post
    {
        public function __construct(
            public int $ID,
        ) {}
    }
}

namespace Modularity\Module\Posts\TemplateController {
    class ListTemplate
    {
        /** @var array<string, mixed> */
        public array $data = [];

        public function __construct(object $module)
        {
            $GLOBALS['modularity_posts_extensions_test_list_template_modules'][] = $module;

            $this->data = $module->data;
            $this->data['posts'] = array_map(static fn(\WP_Post $post): object => (object) [
                'decoratedFrom' => $post->ID,
                'icon' => 'arrow_forward',
            ], $module->data['posts']);
        }
    }
}
