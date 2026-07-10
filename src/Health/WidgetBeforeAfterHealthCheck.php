<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Health;

use Capell\LayoutBuilder\Health\AbstractWidgetExtensionHealthCheck;
use Capell\WidgetBeforeAfter\Filament\BeforeAfterWidget;

final class WidgetBeforeAfterHealthCheck extends AbstractWidgetExtensionHealthCheck
{
    public static function compatibleCapellApiVersion(): string
    {
        return '^4.1';
    }

    protected static function definitionKey(): string
    {
        return 'capell-app.before-after';
    }

    protected static function filamentWidget(): string
    {
        return BeforeAfterWidget::class;
    }

    protected static function fallbackView(): string
    {
        return 'capell-widget-before-after::widget';
    }

    protected static function resourceGroups(): array
    {
        return ['capell-app.widget-before-after'];
    }
}
