<?php

declare(strict_types=1);

namespace MunicipioModularityPostsExtensions\Tests;

use MunicipioModularityPostsExtensions\Fields;
use PHPUnit\Framework\TestCase;

final class FieldsTest extends TestCase
{
    public function testItRendersASelectedMixedChoiceWithoutChangingMunicipioChoices(): void
    {
        $field = [
            'name' => 'acf[field_571dfd4c0d9d9]',
            'value' => 'mixed',
            'choices' => [
                'municipio-choice' => [
                    'image-select-repeater-label' => 'List',
                    'image-select-repeater-value' => 'list',
                ],
            ],
        ];
        $original = $field;

        ob_start();
        Fields::renderMixedChoice($field);
        $html = ob_get_clean();

        static::assertSame($original, $field);
        static::assertIsString($html);
        static::assertStringContainsString('name="acf[field_571dfd4c0d9d9]"', $html);
        static::assertStringContainsString('value="mixed" checked="checked"', $html);
        static::assertStringContainsString('class="image-select__image"', $html);
        static::assertStringContainsString('<p>Cards and list</p>', $html);
    }

    public function testItLeavesTheChoiceUncheckedForAnotherSavedLayout(): void
    {
        ob_start();
        Fields::renderMixedChoice([
            'name' => 'acf[field_571dfd4c0d9d9]',
            'value' => 'list',
        ]);
        $html = ob_get_clean();

        static::assertIsString($html);
        static::assertStringContainsString('value="mixed">', $html);
        static::assertStringNotContainsString('checked="checked"', $html);
    }

    public function testItDoesNotRenderWithoutAnInputName(): void
    {
        ob_start();
        Fields::renderMixedChoice(['value' => 'mixed']);

        static::assertSame('', ob_get_clean());
    }
}
