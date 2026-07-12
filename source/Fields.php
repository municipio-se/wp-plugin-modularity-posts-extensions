<?php

declare(strict_types=1);

namespace MunicipioModularityPosts;

final class Fields
{
    /**
     * Preserve the LTS value and ACF field key so imported modules remain editable without a
     * write migration. Existing choices belong to Municipio and must not be replaced.
     *
     * @param array<string, mixed> $field
     * @return array<string, mixed>
     */
    public static function addMixedChoice(array $field): array
    {
        $choices = $field['choices'] ?? [];
        $field['choices'] = is_array($choices) ? $choices : [];
        $field['choices']['mixed'] = _x('Cards and list', 'Posts Module Display Mode', 'modularity-posts');

        return $field;
    }
}
