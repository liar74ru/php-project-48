<?php

namespace Php\Package;

use function Php\Package\stylishFormat;
use function Php\Package\plainFormat;

function formatter(array $diff, string $format): string
{
    $result = match ($format) {
        'stylish' => stylishFormat($diff),
        'plain' => plainFormat($diff),
        //'json' => '3', //jsonFormat($fileData1, $fileData2),
        default => throw new \Exception("Unknown format: $format"),
    };
    return $result;
}
