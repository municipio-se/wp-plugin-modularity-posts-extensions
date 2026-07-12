<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);
define('MODULARITY_PATH', '/theme/Modularity/');
define('MODULARITY_POSTS_PATH', dirname(__DIR__) . '/');
define('MODULARITY_POSTS_URL', 'https://example.test/wp-content/plugins/modularity-posts/');
define('MODULARITY_POSTS_VERSION', '0.1.0');

$GLOBALS['modularity_posts_test_actions'] = [];
$GLOBALS['modularity_posts_test_filters'] = [];
$GLOBALS['modularity_posts_test_styles'] = [];
$GLOBALS['modularity_posts_test_textdomains'] = [];

function add_action(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
{
    $GLOBALS['modularity_posts_test_actions'][] = [$hook, $callback, $priority, $acceptedArgs];
}

function add_filter(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
{
    $GLOBALS['modularity_posts_test_filters'][] = [$hook, $callback, $priority, $acceptedArgs];
}

function load_plugin_textdomain(string $domain, bool $deprecated, string $path): void
{
    $GLOBALS['modularity_posts_test_textdomains'][] = [$domain, $deprecated, $path];
}

function wp_enqueue_style(...$args): void
{
    $GLOBALS['modularity_posts_test_styles'][] = $args;
}

function _x(string $text): string
{
    return $text;
}

require dirname(__DIR__) . '/vendor/autoload.php';
