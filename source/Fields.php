<?php

declare(strict_types=1);

namespace MunicipioModularityPostsExtensions;

final class Fields
{
    /**
     * Municipio's image-select field derives preview image paths from saved values and cannot
     * accept plugin-owned images through its choices array. Render the additional radio beside
     * the built-in choices so the stable `mixed` value and the visual editor both remain intact.
     *
     * @param array<string, mixed> $field
     */
    public static function renderMixedChoice(array $field): void
    {
        $name = $field['name'] ?? null;

        if (!is_string($name) || $name === '') {
            return;
        }

        $checked = ($field['value'] ?? null) === 'mixed' ? ' checked="checked"' : '';
        $label = _x('Cards and list', 'Posts Module Display Mode', 'modularity-posts-extensions');

        printf(
            '<label class="image-select__label acf-input modularity-posts-extensions-mixed-choice">'
            . '<input class="image-select__radio" type="radio" name="%s" value="mixed"%s>'
            . '<svg class="image-select__checkmark" viewBox="0 0 64 64" aria-hidden="true" focusable="false">'
            . '<path d="M32 2C15.4 2 2 15.4 2 32s13.4 30 30 30 30-13.4 30-30S48.6 2 32 2Zm-7 48L11 35.6l7-7.2 7 7.2L46 14l7 7.2Z" fill="#43a047"/>'
            . '</svg>'
            . '<svg class="image-select__image" viewBox="0 0 345 333" aria-hidden="true" focusable="false">'
            . '<rect width="345" height="333" fill="#f5f5f5"/>'
            . '<rect x="16" y="18" width="313" height="34" rx="5" fill="#c9cfd4"/>'
            . '<rect x="16" y="72" width="150" height="237" fill="#fff" stroke="#c3c4c7"/>'
            . '<rect x="26" y="82" width="130" height="112" fill="#d9d9d9"/>'
            . '<rect x="26" y="212" width="88" height="16" rx="4" fill="#bebebe"/>'
            . '<rect x="26" y="244" width="120" height="51" rx="4" fill="#c9cfd4"/>'
            . '<rect x="184" y="72" width="145" height="37" rx="5" fill="#c9cfd4"/>'
            . '<rect x="184" y="122" width="145" height="37" rx="5" fill="#c9cfd4"/>'
            . '<rect x="184" y="172" width="145" height="37" rx="5" fill="#c9cfd4"/>'
            . '<rect x="184" y="222" width="145" height="37" rx="5" fill="#c9cfd4"/>'
            . '<rect x="184" y="272" width="145" height="37" rx="5" fill="#c9cfd4"/>'
            . '</svg>'
            . '<p>%s</p>'
            . '</label>',
            esc_attr($name),
            $checked,
            esc_html($label),
        );
    }
}
