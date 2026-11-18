# Before and After Widget

<!-- prettier-ignore-start -->

Two photos side by side rarely show how much a job changed. Here your before and after shots become one picture, and visitors move a slider underneath it to reveal the change. A kitchen fitter or a cosmetic clinic can let the photos make the case.

Setting one up takes two uploads. Each photo gets a short label, such as "March" and "June", and a line describing it for visitors who can't see it. Then you choose where the slider starts, halfway unless you change it, and whether the after photo spreads in from the left or from the top. Visitors work the slider with a finger, a mouse or the arrow keys.

Nothing crops or lines the photos up for you, and two shots of the same size taken from the same spot work best. Each comparison holds one pair, and a page can carry several. If a visitor's browser blocks scripts, the two photos sit side by side, each with its label.

- **Price and availability:** Check current availability and price on the [Capell Marketplace listing](https://capell.app/extensions/widget-before-after).
- **Licence:** Check the licence terms on the [Capell Marketplace listing](https://capell.app/extensions/widget-before-after).
- **Requires:** `PHP ^8.4`, `capell-app/admin ^1.0`, `capell-app/core ^1.0.66`, `capell-app/frontend ^1.0`, `capell-app/layout-builder ^1.0.44`, `spatie/laravel-package-tools ^1.0`.
- **Install:** `composer require capell-app/widget-before-after`.

## Quick Start

1. Install the package: `composer require capell-app/widget-before-after`.
2. Open a page, click **Layout builder**, **Add widgets**, then choose **Before and After**.

## For Developers

A typed widget definition keeps editor input, render data, and the Blade fallback behind one registered Layout Builder extension.

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
