<?php

namespace Differ\Differ;

use function Differ\Parser\parser;
use function Differ\Formatter\formatter;
use function Differ\GetFileData\getFileData;
use function Differ\Diff\diff;

function genDiff(string $firstFile, string $secondFile, string $format = 'stylish'): string
{
    $fileData1 = parser(getFileData($firstFile));
    $fileData2 = parser(getFileData($secondFile));
    $values = diff($fileData1, $fileData2);
    $result = formatter($values, $format);

    return $result;
}
