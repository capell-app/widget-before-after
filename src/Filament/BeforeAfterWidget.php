<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Filament;

use Capell\Admin\Contracts\Widgets\FilamentWidget;
use Capell\LayoutBuilder\Filament\Components\Forms\WidgetFileUpload;
use Capell\WidgetBeforeAfter\Enums\ComparisonOrientation;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TextInput;

final class BeforeAfterWidget implements FilamentWidget
{
    public static function getWidgetName(): string
    {
        return 'capell-app.before-after';
    }

    public static function make(): Block
    {
        return Block::make(self::getWidgetName())->label(__('capell-widget-before-after::widget.label'))->schema([WidgetFileUpload::make('beforeImage')->image()->required(), TextInput::make('beforeAlt')->required()->maxLength(180), TextInput::make('beforeLabel')->required()->maxLength(60), WidgetFileUpload::make('afterImage')->image()->required(), TextInput::make('afterAlt')->required()->maxLength(180), TextInput::make('afterLabel')->required()->maxLength(60), Select::make('orientation')->options(ComparisonOrientation::class)->default(ComparisonOrientation::Horizontal->value)->required(), Slider::make('startingPosition')->range(minValue: 0, maxValue: 100)->default(50)]);
    }
}
