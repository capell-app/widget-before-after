<?php

declare(strict_types=1);

use Capell\LayoutBuilder\Support\WidgetExtensions\WidgetExtensionRegistry;
use Capell\WidgetBeforeAfter\Data\BeforeAfterInputData;
use Capell\WidgetBeforeAfter\Health\WidgetBeforeAfterHealthCheck;
use Capell\WidgetBeforeAfter\Providers\WidgetBeforeAfterServiceProvider;
use Illuminate\Validation\ValidationException;

beforeEach(function (): void {
    $this->app->register(WidgetBeforeAfterServiceProvider::class);
});

it('registers healthy authoring rendering and asset surfaces', function (): void {
    expect(resolve(WidgetExtensionRegistry::class)->definition('capell-app.before-after'))->not->toBeNull()
        ->and(WidgetBeforeAfterHealthCheck::passed())->toBeTrue();
});

it('bounds position orientation and local media', function (): void {
    expect(fn () => BeforeAfterInputData::validateAndCreate(['beforeImage' => 'https://remote.test/a.jpg', 'beforeAlt' => 'Before', 'beforeLabel' => 'Before', 'afterImage' => 'after.jpg', 'afterAlt' => 'After', 'afterLabel' => 'After', 'orientation' => 'diagonal', 'startingPosition' => 101]))->toThrow(ValidationException::class);
});
