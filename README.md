# Modularity Posts Extensions

Modularity Posts Extensions adds focused display behavior from Municipio LTS to
the Posts module built into modern Municipio. It extends that module without
owning or replacing it, restoring Municipio Extended, or depending on the
deprecated standalone Modularity plugin.

## Supported first port

- The existing Posts module and its metadata remain the source of truth.
- `posts_display_as=mixed` is exposed as **Cards and list** without a write
  migration.
- The first two posts in Municipio's prepared order render as cards.
- Remaining posts render as a compact title list.
- Zero posts render no empty card or list shell; one or two posts render cards
  only.
- Existing title, preamble, card field choices, archive link, post order,
  sticky-post precedence, and post sources remain owned by Municipio.

Taxonomy display, slider combinations, pagination changes, new data sources, and
other LTS Posts layouts are intentionally outside this release.

## Installation

Install `municipio/wp-plugin-modularity-posts-extensions` with Composer.
Composer Installers places it in
`wp-content/plugins/modularity-posts-extensions` through
`extra.installer-name`.

The plugin supports modern Municipio only. The initial compatibility contract is
verified against `helsingborg-stad/municipio` 6.43.2, where Modularity is
bundled with the theme.

## Data migration

No activation or write migration runs. The plugin preserves the existing field
key and `mixed` value, so imported modules become editable and render correctly
as soon as the plugin is active. Deactivation leaves stored metadata untouched.

## Extension points

The plugin consumes these Municipio and ACF filters:

- `acf/render_field/key=field_571dfd4c0d9d9` renders the plugin-owned `mixed`
  option beside Municipio's current image choices without changing their field
  schema.
- `Modularity/Module/Posts/template` selects the plugin-owned composition for
  `mixed` only.
- `Modularity/Module/posts/TemplatePath` makes the plugin view discoverable
  during Modularity's initial template lookup.
- `/Modularity/externalViewPath` combines the plugin view root with Municipio's
  Posts partials after the template has been selected.

The private template allowlist in Municipio 6.43.2 intentionally falls back to
list preparation for unknown saved values. The plugin uses that prepared
post-object contract and stops routing all formats except `mixed`.

## Layout and accessibility

The plugin composes Municipio's current card, collection, typography, title, and
archive-link partials. Plugin-owned CSS Grid uses the site's `--grid-gap` token
and content-driven columns with an 18 rem minimum, without customer-specific
breakpoints or copied LTS utilities.

Link semantics and interaction states remain owned by Municipio's components.
The mixed view adds unique heading associations for list links and preserves
link attributes prepared by Municipio.

## Development

```console
composer format
composer test
composer lint
```
