<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Data;

use Spatie\LaravelData\Data;

final class BeforeAfterRenderData extends Data
{
    public function __construct(public string $beforeImage, public string $beforeAlt, public string $beforeLabel, public string $afterImage, public string $afterAlt, public string $afterLabel, public string $orientation = 'horizontal', public int $startingPosition = 50) {}
}
