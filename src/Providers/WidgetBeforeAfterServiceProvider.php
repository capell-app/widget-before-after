<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Providers;

use Capell\Core\Enums\PresentationLoadingStrategy;
use Capell\LayoutBuilder\Data\WidgetExtensions\WidgetExtensionCapabilitiesData;
use Capell\LayoutBuilder\Data\WidgetExtensions\WidgetExtensionDefinitionData;
use Capell\LayoutBuilder\Enums\WidgetPresentationCapability;
use Capell\LayoutBuilder\Providers\AbstractFoundationWidgetServiceProvider;
use Capell\WidgetBeforeAfter\Data\BeforeAfterInputData;
use Capell\WidgetBeforeAfter\Data\BeforeAfterRenderData;
use Capell\WidgetBeforeAfter\Filament\BeforeAfterWidget;
use Override;

final class WidgetBeforeAfterServiceProvider extends AbstractFoundationWidgetServiceProvider
{
    public static string $name = 'capell-widget-before-after';

    public static string $packageName = 'capell-app/widget-before-after';

    #[Override]
    public function packageBooted(): void {}

    #[Override]
    protected static function resourceGroup(): string
    {
        return 'capell-app.widget-before-after';
    }

    #[Override]
    protected function bootInstalledRuntime(): void
    {
        $this->registerWidget();
    }

    #[Override]
    protected function definition(): WidgetExtensionDefinitionData
    {
        return new WidgetExtensionDefinitionData(key: 'capell-app.before-after', packageName: self::$packageName, stateVersion: 1, filamentWidget: BeforeAfterWidget::class, inputData: BeforeAfterInputData::class, renderData: BeforeAfterRenderData::class, fallbackView: 'capell-widget-before-after::widget', components: ['blade' => 'capell::widgets.capell-app.before-after'], resourceGroups: [self::resourceGroup()], defaultResourceLoadingStrategy: PresentationLoadingStrategy::Visible, capabilities: new WidgetExtensionCapabilitiesData(requiresInstanceIdentity: true, presentationCapabilities: [WidgetPresentationCapability::Width, WidgetPresentationCapability::Alignment, WidgetPresentationCapability::LoadingStrategy]));
    }
}
