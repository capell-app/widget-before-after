<?php

declare(strict_types=1);

use Capell\Core\Enums\ContentStructure;
use Capell\Core\Facades\CapellCore;
use Capell\Core\Models\Layout;
use Capell\Core\Models\Page;
use Capell\Core\Models\Site;
use Capell\Core\Models\SiteDomain;
use Capell\Frontend\Data\FrontendRenderContextData;
use Capell\LayoutBuilder\Support\LayoutBuilderLayoutWidgetResourceUsageContributor;
use Capell\WidgetBeforeAfter\Providers\WidgetBeforeAfterServiceProvider;
use Dom\Element;
use Dom\HTMLDocument;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

require_once dirname(__DIR__, 4) . '/tests/Packages/Support/PublicOutputSafety.php';

beforeEach(function (): void {
    CapellCore::forcePackageInstalled('capell-app/widget-before-after');
    $this->app->register(WidgetBeforeAfterServiceProvider::class);
});

/**
 * Publishes a page at /comparison whose content holds one before-after widget.
 *
 * @param  array<string, mixed>  $presentation
 */
function seedBeforeAfterPublicPage(array $presentation = [], bool $blueprintDeclaresBlocks = true): Page
{
    $site = Site::factory()->createOne();
    SiteDomain::query()->updateOrCreate(
        ['site_id' => $site->id, 'domain' => 'localhost', 'path' => null],
        ['scheme' => 'http', 'language_id' => $site->language_id, 'status' => true, 'default' => true],
    );

    $capell = [
        'instance_id' => '0f8fad5b-d9cb-469f-a165-70867728950e', 'state_version' => 1,
        'model_id' => 424242, 'field_path' => 'content.0.data',
        'permissions' => ['update'], 'selector' => '[data-model-id="424242"]',
    ];
    if ($presentation !== []) {
        $capell['presentation'] = $presentation;
    }

    $page = Page::factory()->site($site)
        ->state(['content_structure_override' => ContentStructure::Blocks->value])
        ->withTranslations($site->language, ['title' => 'Comparison', 'content' => [[
            'type' => 'capell-app.before-after',
            'data' => [
                'beforeImage' => 'before.jpg', 'beforeAlt' => 'Before', 'beforeLabel' => 'Before',
                'afterImage' => 'after.jpg', 'afterAlt' => 'After', 'afterLabel' => 'After',
                'orientation' => 'horizontal', 'startingPosition' => 50,
                '__capell' => $capell,
            ],
        ]]], slug: '/comparison', contentStructure: ContentStructure::Blocks)
        ->createOne();

    if ($blueprintDeclaresBlocks) {
        $blueprint = $page->blueprint;
        $blueprint->forceFill(['meta' => [...($blueprint->meta ?? []), 'content_structure' => ContentStructure::Blocks->value]])->save();
    }

    return $page;
}

function beforeAfterPublicDocument(): HTMLDocument
{
    $response = resolve(Kernel::class)->handle(Request::create('/comparison'));
    expect($response->getStatusCode())->toBe(Response::HTTP_OK);
    $html = $response->getContent();

    return HTMLDocument::createFromString(is_string($html) ? $html : '', LIBXML_NOERROR);
}

/** @return list<array<mixed>> */
function beforeAfterLazyActivations(HTMLDocument $document): array
{
    $manifest = $document->querySelector('script[type="application/json"][data-capell-widget-assets]');
    $decoded = $manifest instanceof Element ? json_decode((string) $manifest->textContent, true, flags: JSON_THROW_ON_ERROR) : [];

    return is_array($decoded) ? array_values(array_filter($decoded, is_array(...))) : [];
}

function beforeAfterStylesheetUrl(): string
{
    return url('/vendor/capell-widget-before-after/widget.css');
}

function beforeAfterHtmlOccurrences(HTMLDocument $document, string $needle): int
{
    return substr_count($document->saveHtml(), $needle);
}

it('activates the widget stylesheet and script when the widget becomes visible or idle', function (string $loadingStrategy, array $presentation): void {
    seedBeforeAfterPublicPage($presentation);
    $document = beforeAfterPublicDocument();
    $publicId = LayoutBuilderLayoutWidgetResourceUsageContributor::resourceGroupPublicId('capell-app.widget-before-after');

    $runtime = $document->querySelector('[data-capell-widget-runtime]');
    expect($runtime)->not->toBeNull()
        ->and($runtime?->querySelector('[data-capell-widget-before-after]'))->not->toBeNull()
        ->and(json_decode((string) $runtime?->getAttribute('data-capell-widget-resources'), true))->toBe([$publicId])
        ->and(json_decode((string) $runtime?->getAttribute('data-capell-widget-settings'), true))->toMatchArray(['loading_strategy' => $loadingStrategy]);

    $activations = beforeAfterLazyActivations($document);
    expect($activations)->toHaveCount(1)
        ->and($activations[0]['target'])->toBe($publicId)
        ->and($activations[0]['loading'])->toBe($loadingStrategy)
        ->and(data_get($activations[0], 'layers.0.*.url'))->toBe([
            beforeAfterStylesheetUrl(),
            url('/vendor/capell-widget-before-after/widget.js'),
        ])
        ->and($document->querySelector('link[rel="stylesheet"][href="' . beforeAfterStylesheetUrl() . '"]'))->toBeNull()
        ->and(beforeAfterHtmlOccurrences($document, 'capell-widget-before-after\/widget.css'))->toBe(1);
})->with([
    'visible by default' => ['visible', []],
    'idle instance strategy' => ['idle', ['loading_strategy' => 'idle']],
]);

it('links the widget stylesheet in the document head once when loaded eagerly', function (): void {
    seedBeforeAfterPublicPage(['loading_strategy' => 'eager']);
    $document = beforeAfterPublicDocument();

    expect($document->head?->querySelectorAll('link[rel="stylesheet"][href="' . beforeAfterStylesheetUrl() . '"]'))->toHaveCount(1)
        ->and(beforeAfterLazyActivations($document))->toBe([])
        ->and(beforeAfterHtmlOccurrences($document, 'capell-widget-before-after/widget.css'))->toBe(1);
});

it('activates widget resources on a block-structured page whose blueprint declares no structure', function (): void {
    seedBeforeAfterPublicPage(blueprintDeclaresBlocks: false);
    $document = beforeAfterPublicDocument();

    expect($document->querySelector('[data-capell-widget-before-after]'))->not->toBeNull()
        ->and(beforeAfterLazyActivations($document))->toHaveCount(1);
});

it('collects canonical extension resources stored in layout containers', function (): void {
    $page = seedBeforeAfterPublicPage();
    $translation = $page->translations->firstOrFail();
    $blocks = $translation->content;
    $layout = Layout::factory()->createOne(['containers' => [
        'main' => ['meta' => ['colspan' => 12], 'widgets' => $blocks],
    ]]);
    $page->forceFill(['layout_id' => $layout->id])->save();
    $translation->forceFill(['content' => null])->save();

    $site = $page->site ?? throw new LogicException('Expected the public page fixture to belong to a site.');
    $context = new FrontendRenderContextData($page, $site, $site->language, $layout, null);
    $usages = resolve(LayoutBuilderLayoutWidgetResourceUsageContributor::class)->usages($context);

    expect($usages)->toHaveCount(1)
        ->and($usages[0]->resourceGroup)->toBe('capell-app.widget-before-after')
        ->and($usages[0]->presentation->loadingStrategy->value)->toBe('visible');
});

it('keeps authoring internals out of the whole anonymous document and lazy manifest', function (): void {
    seedBeforeAfterPublicPage();
    $document = beforeAfterPublicDocument();
    $manifest = $document->querySelector('script[type="application/json"][data-capell-widget-assets]');

    expect($manifest)->toBeInstanceOf(Element::class);
    $manifestJson = (string) $manifest?->textContent;
    $forbidden = [
        'capell-app.before-after', 'capell-app.widget-before-after',
        '0f8fad5b-d9cb-469f-a165-70867728950e', '__capell', 'instance_id', 'state_version',
        'content.0.data', 'field_path', 'fieldPath', 'model_id', 'modelId', 'page_id', 'pageId',
        'permissions', 'selector', '424242', 'data-field=', 'data-page=',
    ];

    expect($document->saveHtml())->not->toContain(...$forbidden)
        ->and($manifestJson)->not->toContain(...$forbidden);
    assertCapellPublicOutputIsSafe($document->saveHtml(), 'Before-after anonymous document');
    assertCapellPublicOutputIsSafe($manifestJson, 'Before-after lazy manifest');
});
