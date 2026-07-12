<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter;

use Capell\Core\Contracts\Extensions\RegistersExtensionContentWidget;

final class WidgetBeforeAfterContribution implements RegistersExtensionContentWidget
{
    public static function compatibleCapellApiVersion(): string
    {
        return '^1.0';
    }
}
