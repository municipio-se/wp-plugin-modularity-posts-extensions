# Repository instructions

## Scope

This plugin ports focused display behavior for the Posts module in modern
Municipio. Keep it independent of Municipio Cloud and the deprecated standalone
Modularity plugin.

Preserve the `posts_display_as=mixed` contract. Do not add other LTS layouts,
taxonomy display, sliders, pagination, or data sources without a separately
confirmed outcome.

## Verification

Run these commands after changing PHP or runtime behavior:

```console
composer format
composer test
composer lint
```
