# Repository instructions

## Scope

This plugin extends the Posts module that is built into modern Municipio with
focused display behavior ported from Municipio LTS. It does not own or replace
the Posts module. Keep it independent of Municipio Cloud and the deprecated
standalone Modularity plugin.

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
