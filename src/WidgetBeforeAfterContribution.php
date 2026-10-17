<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter;

use Capell\Core\Contracts\Extensions\RegistersExtensionAsset;
use Capell\Core\Contracts\Extensions\RegistersExtensionContentWidget;
use Override;

final class WidgetBeforeAfterContribution implements RegistersExtensionAsset, RegistersExtensionContentWidget
{
    #[Override]
    public static function compatibleCapellApiVersion(): string
    {
        return '^1.0';
    }
}
