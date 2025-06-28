<?php

namespace Php\Package;

use function Php\Package\parseJson;
use function Php\Package\parseYml;

const TEXT_INDEX = [
    'added' => '+ ',
    'deleted' => '- ',
    'unchanged' => '  ',
    'nested' => '  ',
    'addedNested' => '+ ',
    'deletedNested' => '- ',
];

function toString(string $value): string
{
    return trim(var_export($value, true), "'");
}

function stylishFormat(array $diff, int $spacesCount = 2, int $depth = 1): string
{
    // Diff-структура
    $result = "{\n";
    $step = str_repeat(' ', $spacesCount * $depth);
    $aStep = str_repeat(' ', $spacesCount * ($depth - 1));
    foreach ($diff as [$status, $key, $value]) {
        if ($status === 'nested' || $status === 'addedNested' || $status === 'deletedNested') {
            $nestedValue = stylishFormat($value, $spacesCount, $depth + 2);
            $result .= $step . TEXT_INDEX[$status] . "$key: $nestedValue\n";
            continue;
        }
        $value = is_array($value)
        ? stylishFormat($value, $spacesCount, $depth + 2)
        : (is_bool($value) ? ($value ? 'true' : 'false')
        : ($value === null ? 'null' : toString((string)$value)));
        $result .= $step . TEXT_INDEX[$status] . "$key: $value\n";
    }
    $result .= $aStep . "}";
    return $result;
}
