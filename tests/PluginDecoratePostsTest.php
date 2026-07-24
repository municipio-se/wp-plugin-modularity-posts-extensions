<?php

declare(strict_types=1);

namespace MunicipioModularityPostsExtensions\Tests;

use MunicipioModularityPostsExtensions\Plugin;
use PHPUnit\Framework\TestCase;

final class PluginDecoratePostsTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['modularity_posts_extensions_test_list_template_modules'] = [];
    }

    public function testItDecoratesRawWpPostsThroughTheListTemplateBeforePartitioning(): void
    {
        $rawPosts = array_map(static fn(int $id): \WP_Post => new \WP_Post($id), range(1, 3));
        $module = (object) ['data' => ['posts' => $rawPosts]];

        $template = (new Plugin())->routeTemplate(
            'list.blade.php',
            $module,
            ['posts' => $rawPosts],
            ['posts_display_as' => 'mixed', 'posts_fields' => ['title']],
        );

        static::assertSame('mixed.blade.php', $template);
        static::assertSame([$module], $GLOBALS['modularity_posts_extensions_test_list_template_modules']);
        static::assertSame([1, 2], array_column($module->data['mixedCards'], 'decoratedFrom'));
        static::assertSame([3], array_column($module->data['mixedList'], 'decoratedFrom'));
    }

    public function testItLeavesPostsPreparedByMunicipio643OrLaterUntouched(): void
    {
        $preparedPosts = array_map(static fn(int $id): object => (object) ['preparedId' => $id], range(1, 3));
        $module = (object) ['data' => ['posts' => $preparedPosts]];

        $template = (new Plugin())->routeTemplate(
            'list.blade.php',
            $module,
            ['posts' => $preparedPosts],
            ['posts_display_as' => 'mixed', 'posts_fields' => ['title']],
        );

        static::assertSame('mixed.blade.php', $template);
        static::assertSame([$preparedPosts[0], $preparedPosts[1]], $module->data['mixedCards']);
        static::assertSame([$preparedPosts[2]], $module->data['mixedList']);
    }
}
