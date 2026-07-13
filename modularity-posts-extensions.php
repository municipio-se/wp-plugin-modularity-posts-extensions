<?php

/**
 * Plugin Name: Modularity Posts Extensions
 * Description: Adds focused Posts module display modes to modern Municipio.
 * Version: 0.1.0
 * Requires PHP: 8.2
 * Author: Whitespace
 * License: MIT
 * Text Domain: modularity-posts-extensions
 * Domain Path: /languages
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit();
}

define('MODULARITY_POSTS_EXTENSIONS_FILE', __FILE__);
/**
 * Composer's installer-name is the production path contract. Resolving the fixed slug through
 * WordPress also keeps plugin-owned views and assets valid when the local package is symlinked.
 */
define('MODULARITY_POSTS_EXTENSIONS_PATH', trailingslashit(WP_PLUGIN_DIR) . 'modularity-posts-extensions/');
define('MODULARITY_POSTS_EXTENSIONS_URL', trailingslashit(plugins_url('modularity-posts-extensions')));
define('MODULARITY_POSTS_EXTENSIONS_VERSION', '0.1.0');

$autoload = MODULARITY_POSTS_EXTENSIONS_PATH . 'vendor/autoload.php';

if (is_readable($autoload)) {
    require_once $autoload;
}

if (class_exists(\MunicipioModularityPostsExtensions\Plugin::class)) {
    (new \MunicipioModularityPostsExtensions\Plugin())->register();
}
