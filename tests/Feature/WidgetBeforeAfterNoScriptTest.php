<?php

declare(strict_types=1);

/*
 * Bug caught: with scripts blocked the slider still showed but did nothing.
 * The range control must stay hidden until the script marks the widget ready.
 */
it('hides the range control until the script marks the widget ready', function (): void {
    $css = (string) file_get_contents(dirname(__DIR__, 2) . '/resources/dist/widget.css');
    $view = (string) file_get_contents(dirname(__DIR__, 2) . '/resources/views/widget.blade.php');

    expect($css)->toMatch('/\.capell-before-after:not\(\.is-ready\)\s+label\s*\{\s*display:\s*none;/')
        ->and($view)->toMatch('/<label\b.*?data-comparison-range/s');
});
