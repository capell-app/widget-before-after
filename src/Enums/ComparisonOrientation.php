<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Enums;

use Filament\Support\Contracts\HasLabel;

enum ComparisonOrientation: string implements HasLabel
{
    case Horizontal = 'horizontal';
    case Vertical = 'vertical';

    public function getLabel(): string
    {
        return match ($this) {
            self::Horizontal => __('capell-widget-before-after::widget.horizontal'),
            self::Vertical => __('capell-widget-before-after::widget.vertical'),
        };
    }
}
