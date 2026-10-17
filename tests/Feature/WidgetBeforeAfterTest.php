<?php

declare(strict_types=1);

use Capell\Core\Facades\CapellCore;
use Capell\Frontend\Actions\AssertPublicHtmlContainsNoAuthoringSurfaceAction;
use Capell\Frontend\Support\Security\PublicHtmlSafetyInspector;
use Capell\LayoutBuilder\Support\WidgetExtensions\WidgetExtensionRegistry;
use Capell\WidgetBeforeAfter\Data\BeforeAfterInputData;
use Capell\WidgetBeforeAfter\Data\BeforeAfterRenderData;
use Capell\WidgetBeforeAfter\Health\WidgetBeforeAfterHealthCheck;
use Capell\WidgetBeforeAfter\Providers\WidgetBeforeAfterServiceProvider;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function (): void {
    CapellCore::forcePackageInstalled('capell-app/widget-before-after');
    $this->app->register(WidgetBeforeAfterServiceProvider::class);
});

it('registers healthy authoring rendering and asset surfaces', function (): void {
    expect(resolve(WidgetExtensionRegistry::class)->definition('capell-app.before-after'))->not->toBeNull()
        ->and(WidgetBeforeAfterHealthCheck::passed())->toBeTrue();
});

it('bounds position orientation and local media', function (): void {
    expect(fn (): BeforeAfterInputData => BeforeAfterInputData::validateAndCreate(['beforeImage' => 'https://remote.test/a.jpg', 'beforeAlt' => 'Before', 'beforeLabel' => 'Before', 'afterImage' => 'after.jpg', 'afterAlt' => 'After', 'afterLabel' => 'After', 'orientation' => 'diagonal', 'startingPosition' => 101]))->toThrow(ValidationException::class);
});

it('renders public before-after markup accepted by the public HTML safety action', function (): void {
    $renderData = BeforeAfterRenderData::from(['beforeImage' => 'before.jpg', 'beforeAlt' => 'Before', 'beforeLabel' => 'Before', 'afterImage' => 'after.jpg', 'afterAlt' => 'After', 'afterLabel' => 'After']);
    $html = view('capell-widget-before-after::widget', ['renderData' => $renderData])->render();

    expect($html)->toContain('data-capell-widget-before-after')
        ->not->toContain('data-capell-before-after');

    AssertPublicHtmlContainsNoAuthoringSurfaceAction::run(new Response(
        '<!doctype html><html><body>' . $html . '</body></html>',
        Response::HTTP_OK,
        ['Content-Type' => 'text/html'],
    ));

    expect(resolve(PublicHtmlSafetyInspector::class)->containsAuthoringSurface(
        '<section data-capell-before-after>Widget</section>',
    ))->toBeTrue();
});
