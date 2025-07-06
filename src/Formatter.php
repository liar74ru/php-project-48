<?php

namespace Differ\Formatter;

use function Differ\Formatter\Stylish\stylishFormat;
use function Differ\Formatter\Plain\plainFormat;
use function Differ\Formatter\Json\jsonFormat;

function formatter(array $diff, string $format): string
{
    $result = match ($format) {
        'stylish' => stylishFormat($diff),
        'plain' => plainFormat($diff),
        'json' => jsonFormat($diff),
        default => throw new \Exception("Unknown format: $format"),
    };
    return $result;
}
