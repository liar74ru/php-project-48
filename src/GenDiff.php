<?php

namespace Differ\Differ;

use function Php\Package\parser;
use function Php\Package\formatter;
use function Php\Package\getFileData;
use function Php\Package\diff;

function genDiff(string $firstFile, string $secondFile, string $format = 'stylish'): string
{
    $fileData1 = parser(getFileData($firstFile));
    $fileData2 = parser(getFileData($secondFile));
    $values = diff($fileData1, $fileData2);
    $result = formatter($values, $format);

    return $result;
}
