<?php

declare(strict_types=1);

namespace MunicipioModularityPostsExtensions\Tests;

use MunicipioModularityPostsExtensions\Plugin;
use PHPUnit\Framework\TestCase;

final class PluginTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['modularity_posts_extensions_test_actions'] = [];
        $GLOBALS['modularity_posts_extensions_test_filters'] = [];
        $GLOBALS['modularity_posts_extensions_test_styles'] = [];
        $GLOBALS['modularity_posts_extensions_test_textdomains'] = [];
    }

    public function testItRegistersOnlyRuntimeHooksAndNoWriteMigration(): void
    {
        (new Plugin())->register();

        static::assertSame(
            ['init', 'wp_enqueue_scripts', 'acf/render_field/key=field_571dfd4c0d9d9'],
            array_column($GLOBALS['modularity_posts_extensions_test_actions'], 0),
        );
        static::assertSame(
            [
                'Modularity/Module/Posts/template',
                'Modularity/Module/posts/TemplatePath',
                '/Modularity/externalViewPath',
            ],
            array_column($GLOBALS['modularity_posts_extensions_test_filters'], 0),
        );
    }

    public function testItAddsItsViewRootToTheInitialTemplateLookup(): void
    {
        $paths = (new Plugin())->registerTemplatePaths(['/theme/Modularity/source/php/Module/Posts/views']);

        static::assertSame(
            [
                '/theme/Modularity/source/php/Module/Posts/views',
                dirname(__DIR__) . '/views',
            ],
            $paths,
        );
    }

    public function testItLoadsItsTextDomainAndEnqueuesAVersionedStylesheet(): void
    {
        $plugin = new Plugin();
        $plugin->loadTextDomain();
        $plugin->enqueueStyles();

        static::assertSame(
            [
                ['modularity-posts-extensions', false, 'modularity-posts-extensions/languages'],
            ],
            $GLOBALS['modularity_posts_extensions_test_textdomains'],
        );
        static::assertSame(
            [
                'modularity-posts-extensions',
                'https://example.test/wp-content/plugins/modularity-posts-extensions/assets/css/mixed.css',
                [],
                '0.1.0',
            ],
            $GLOBALS['modularity_posts_extensions_test_styles'][0],
        );
    }

    public function testItCombinesMunicipioAndPluginViewRoots(): void
    {
        $paths = (new Plugin())->registerViewPaths([
            'mod-posts' => '/another-extension/views',
        ]);

        static::assertSame(
            [
                '/another-extension/views',
                '/theme/Modularity/source/php/Module/Posts/views',
                dirname(__DIR__) . '/views',
            ],
            $paths['mod-posts'],
        );
    }

    public function testItRoutesOnlyMixedAndPartitionsPreparedPosts(): void
    {
        $module = (object) ['data' => []];
        $posts = range(1, 7);

        $template = (new Plugin())->routeTemplate(
            'list.blade.php',
            $module,
            ['posts' => $posts],
            ['posts_display_as' => 'mixed', 'posts_fields' => ['title', 'date', 'image']],
        );

        static::assertSame('mixed.blade.php', $template);
        static::assertSame([1, 2], $module->data['mixedCards']);
        static::assertSame([3, 4, 5, 6, 7], $module->data['mixedList']);
        static::assertTrue($module->data['showDate']);
    }

    public function testItLeavesOtherTemplatesAndModuleDataUntouched(): void
    {
        $module = (object) ['data' => ['existing' => true]];

        $template = (new Plugin())->routeTemplate(
            'grid.blade.php',
            $module,
            ['posts' => [1, 2, 3]],
            ['posts_display_as' => 'grid'],
        );

        static::assertSame('grid.blade.php', $template);
        static::assertSame(['existing' => true], $module->data);
    }

    public function testItDoesNotShowCardDatesWhenTheFieldIsNotSelected(): void
    {
        $module = (object) ['data' => []];

        (new Plugin())->routeTemplate(
            'list.blade.php',
            $module,
            ['posts' => [1]],
            ['posts_display_as' => 'mixed', 'posts_fields' => ['title', 'image']],
        );

        static::assertFalse($module->data['showDate']);
    }

    public function testTheSwedishRuntimeCatalogContainsTheContextualLabel(): void
    {
        $catalog = require dirname(__DIR__) . '/languages/modularity-posts-extensions-sv_SE.l10n.php';

        static::assertSame('Kort och lista', $catalog['messages']["Posts Module Display Mode\x04Cards and list"]);
    }

    public function testTheViewRendersTheArchiveLinkOnceAndDoesNotHidePostsByLoopIndex(): void
    {
        $view = file_get_contents(dirname(__DIR__) . '/views/mixed.blade.php');

        static::assertIsString($view);
        static::assertSame(1, substr_count($view, "@include('partials.more')"));
        static::assertStringNotContainsString('$loop->index', $view);
    }
}
