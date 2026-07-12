<?php

declare(strict_types=1);

namespace Capell\WidgetBeforeAfter\Data;

use Spatie\LaravelData\Data;

final class BeforeAfterInputData extends Data
{
    public function __construct(public string $beforeImage, public string $beforeAlt, public string $beforeLabel, public string $afterImage, public string $afterAlt, public string $afterLabel, public string $orientation = 'horizontal', public int $startingPosition = 50) {}

    /** @return array<string, list<string>> */
    public static function rules(): array
    {
        $image = ['required', 'string', 'max:2048', 'regex:/^(?![a-z][a-z0-9+.-]*:)(?!\/\/)[A-Za-z0-9_\/.-]+$/i'];

        return ['beforeImage' => $image, 'beforeAlt' => ['required', 'string', 'max:180'], 'beforeLabel' => ['required', 'string', 'max:60'], 'afterImage' => $image, 'afterAlt' => ['required', 'string', 'max:180'], 'afterLabel' => ['required', 'string', 'max:60'], 'orientation' => ['required', 'in:horizontal,vertical'], 'startingPosition' => ['required', 'integer', 'between:0,100']];
    }
}
