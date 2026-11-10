# Before and After Widget reference

<!-- prettier-ignore-start -->

Developer reference for `capell-app/widget-before-after`. Start with the [README](../README.md) for what the extension does and how to install it.

## Package Details

Before and After Widget is an **Available**, **No schema impact** Capell package in the **Capell Essentials** product group. It ships as `capell-app/widget-before-after` and extends these surfaces: admin, frontend.

- Status: Available
- Tier: free
- Bundle: foundation
- Composer package: `capell-app/widget-before-after`
- Namespace: `Capell\WidgetBeforeAfter`
- Theme key: not applicable

## Technical Shape

### Service providers

- `Capell\WidgetBeforeAfter\Providers\WidgetBeforeAfterServiceProvider`

### Filament classes

- `BeforeAfterWidget`

### Data objects

- `BeforeAfterInputData`
- `BeforeAfterRenderData`

### Manifest contributions

- `asset: Capell\WidgetBeforeAfter\WidgetBeforeAfterContribution`
- `content-widget: Capell\WidgetBeforeAfter\WidgetBeforeAfterContribution`

### Health checks

- `Capell\WidgetBeforeAfter\Health\WidgetBeforeAfterHealthCheck`

### Blade views

- `packages/widget-before-after/resources/views/widget.blade.php`

### Cache tags

- `widget-before-after`


## Data Model

This package has no schema impact. It extends Capell through `asset` contributions and `content-widget` contributions instead of declaring package-owned tables.

<!-- prettier-ignore-end -->
