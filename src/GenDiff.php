<?php

namespace Php\Package;

use function Php\Package\parser;
use function Php\Package\stylishFormat;
use function Php\Package\getFileData;

function genDiff(string $firstFile, string $secondFile, string $format = 'stylish'): string
{
    $fileData1 = parser(getFileData($firstFile));
    $fileData2 = parser(getFileData($secondFile));

    $result = match ($format) {
        'stylish' => stylishFormat($fileData1, $fileData2),
        'plain' => 2, //plainFormat($fileData1, $fileData2),
        'json' => 3, //jsonFormat($fileData1, $fileData2),
        default => throw new \Exception("Unknown format: $format"),
    };
    return $result;
}
