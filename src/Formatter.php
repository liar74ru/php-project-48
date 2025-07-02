<?php

namespace Php\Package;

use function Php\Package\stylishFormat;
use function Php\Package\plainFormat;
use function Php\Package\jsonFormat;

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
