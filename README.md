# Before and After Widget

<!-- prettier-ignore-start -->

## What It Does

Before and After adds a Layout Builder widget for comparing two local images with a bounded range control. The public comparison supports keyboard and touch interaction with a non-interactive fallback.

- **Price and availability:** Check current availability and price on the [Capell Marketplace listing](https://capell.app/extensions/widget-before-after).
- **Licence:** Check the licence terms on the [Capell Marketplace listing](https://capell.app/extensions/widget-before-after).
- **Requires:** `PHP ^8.4`, `capell-app/admin ^1.0`, `capell-app/core ^1.0.66`, `capell-app/frontend ^1.0`, `capell-app/layout-builder ^1.0.44`, `spatie/laravel-package-tools ^1.0`.
- **Install:** `composer require capell-app/widget-before-after`.

Editors select the two images and comparison settings in Layout Builder, and visitors can move the public reveal control to inspect the difference.

## Who It Is For

**For developers:** A typed widget definition keeps editor input, render data, and the Blade fallback behind one registered Layout Builder extension.

**For teams:** Teams can explain visual changes in one focused component without preparing separate image states or custom comparison code.

## Quick Start

1. Install the package: `composer require capell-app/widget-before-after`.
2. Open a page, click **Layout builder**, **Add widgets**, then choose **Before and After**.

## Configure

This extension works without configuration. There is nothing to set after install.

## Limits And Pitfalls

- Install the required Capell packages at the versions in `composer.json`: `capell-app/admin ^1.0`, `capell-app/core ^1.0.66`, `capell-app/frontend ^1.0`, `capell-app/layout-builder ^1.0.44`.
- Keep public Blade and cached HTML free of authoring markers, model IDs, permissions, signed editor URLs, and lazy database queries.
- Custom write integrations must preserve invalidation for `widget-before-after` cache tags.

## Screens And Workflow

![Before After public output](docs/screenshots/before-after-public-output.png)

![Before + After fields in Layout Builder](docs/screenshots/before-after-layout-builder-editor.png)

- Before and After Widget extension card (marketplace).
- Before + After fields in Layout Builder (admin).
- Before After public output (frontend).
- Before + After fields in Layout Builder with admin sidebar menu open (admin).

## Install Impact

- Required packages: `capell-app/admin`, `capell-app/core`, `capell-app/frontend`, `capell-app/layout-builder`.
- Admin navigation: no admin page or resource contribution is declared.
- Admin/editor extensions: `content-widget: WidgetBeforeAfterContribution`.
- Permissions: no package permission declarations or Shield gates detected; host access rules still apply.
- Public routes: none declared.
- Database changes: no package migrations declared.
- Config: no package config files.
- Settings: no package settings declared.
- Queues or schedules: none declared.
- Cache tags: `widget-before-after`.
- Commands: none declared.

## Troubleshooting

| Symptom | Likely cause | Check | Fix |
| --- | --- | --- | --- |
| Package surface is missing after install | Provider or manifest is not loaded | Confirm `capell.json`, package `composer.json`, and provider registration | Reinstall the package, refresh Composer autoload, and clear host caches |
| Public output leaks unexpected state | Render data, cache variation, or authoring boundary has regressed | Check public Blade, cache tags, and public-output safety tests | Move data loading out of Blade and rerun the package public-output tests |
| An image is refused | The path is a web address or contains characters outside letters, numbers and `_ / . -` | Check the before and after image fields | Pick both images from the media library |
| The widget will not save | The alt text or label is empty, or the starting position is outside 0 to 100 | Check both alt texts, both labels and the starting position | Fill every alt text and label, and set the position between 0 and 100 |

## Upgrading

No manual steps between minor versions.

## Next Steps

- [Package docs](docs/README.md)
- [Overview](docs/overview.md)
- [Troubleshooting](#troubleshooting)
- [Developer reference](docs/reference.md)
- [Marketplace assets](docs/assets/marketplace/)
- [Capell content language plan](../../docs/CONTENT_LANGUAGE_PLAN.md)
- [Capell documentation design system](../../docs/DESIGN_SYSTEM.md)
- [Capell and package ERD notes](../../docs/erd/capell-and-package-erds.md)
- Related packages: [Layout Builder](../layout-builder/README.md).

<!-- prettier-ignore-end -->
