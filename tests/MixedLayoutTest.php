<?php

declare(strict_types=1);

namespace MunicipioModularityPosts\Tests;

use MunicipioModularityPosts\MixedLayout;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MixedLayoutTest extends TestCase
{
    /**
     * @param array<int, int> $posts
     * @param array<int, int> $cards
     * @param array<int, int> $list
     */
    #[DataProvider('postCounts')]
    public function testItKeepsOrderAndSplitsAfterTwoCards(array $posts, array $cards, array $list): void
    {
        static::assertSame(['cards' => $cards, 'list' => $list], MixedLayout::partition($posts));
    }

    /**
     * @return iterable<string, array{array<int, int>, array<int, int>, array<int, int>}>
     */
    public static function postCounts(): iterable
    {
        yield 'zero posts' => [[], [], []];
        yield 'one post' => [[1], [1], []];
        yield 'two posts' => [[1, 2], [1, 2], []];
        yield 'three posts' => [[1, 2, 3], [1, 2], [3]];
        yield 'seven posts' => [[1, 2, 3, 4, 5, 6, 7], [1, 2], [3, 4, 5, 6, 7]];
    }
}
