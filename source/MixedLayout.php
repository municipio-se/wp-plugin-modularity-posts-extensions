<?php

declare(strict_types=1);

namespace MunicipioModularityPosts;

final class MixedLayout
{
    private const CARD_COUNT = 2;

    /**
     * Partition the already ordered output from Municipio. Sticky-post precedence and all data
     * source rules therefore remain owned by the built-in Posts module.
     *
     * @template T
     * @param array<int, T> $posts
     * @return array{cards: array<int, T>, list: array<int, T>}
     */
    public static function partition(array $posts): array
    {
        return [
            'cards' => array_slice($posts, 0, self::CARD_COUNT),
            'list' => array_slice($posts, self::CARD_COUNT),
        ];
    }
}
