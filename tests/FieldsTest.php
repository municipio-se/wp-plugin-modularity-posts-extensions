<?php

declare(strict_types=1);

namespace MunicipioModularityPosts\Tests;

use MunicipioModularityPosts\Fields;
use PHPUnit\Framework\TestCase;

final class FieldsTest extends TestCase
{
    public function testItAddsMixedWithoutReplacingMunicipioChoices(): void
    {
        $field = Fields::addMixedChoice([
            'choices' => [
                'list' => 'List',
                'grid' => 'Grid',
            ],
        ]);

        static::assertSame(
            [
                'list' => 'List',
                'grid' => 'Grid',
                'mixed' => 'Cards and list',
            ],
            $field['choices'],
        );
    }

    public function testItRepairsMalformedChoicesWithoutChangingTheFieldContract(): void
    {
        $field = Fields::addMixedChoice(['key' => 'field_571dfd4c0d9d9', 'choices' => null]);

        static::assertSame('field_571dfd4c0d9d9', $field['key']);
        static::assertSame(['mixed' => 'Cards and list'], $field['choices']);
    }
}
