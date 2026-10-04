@php /** @var \Capell\WidgetBeforeAfter\Data\BeforeAfterRenderData $renderData */ @endphp
<figure
    class="capell-before-after capell-before-after--{{ $renderData->orientation }}"
    data-capell-widget-before-after
    style="--comparison-position:{{ $renderData->startingPosition }}%"
>
    <div class="capell-before-after__images">
        <div>
            <img
                src="{{ asset('storage/' . ltrim($renderData->beforeImage, '/')) }}"
                alt="{{ $renderData->beforeAlt }}"
            /><span>{{ $renderData->beforeLabel }}</span>
        </div>
        <div data-comparison-after>
            <img
                src="{{ asset('storage/' . ltrim($renderData->afterImage, '/')) }}"
                alt="{{ $renderData->afterAlt }}"
            /><span>{{ $renderData->afterLabel }}</span>
        </div>
    </div>
    <label
        ><span class="capell-visually-hidden">Comparison position</span
        ><input
            type="range"
            min="0"
            max="100"
            value="{{ $renderData->startingPosition }}"
            data-comparison-range
    /></label>
</figure>
