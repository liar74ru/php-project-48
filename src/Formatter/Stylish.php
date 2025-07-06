<?php

namespace Php\Package;

const STATUS_TEXT_INDEX = [
    'added' => '+ ',
    'deleted' => '- ',
    'updateDeleted' => '- ',
    'updateAdded' => '+ ',
    'unchanged' => '  ',
    'nested' => '  ',
    'addedNested' => '+ ',
    'deletedNested' => '- ',
];

function stylishFormat(array $diff, int $spacesCount = 2, int $depth = 1): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $spacesCount) {
        $step = str_repeat(' ', $spacesCount * $depth);
        $aStep = str_repeat(' ', $spacesCount * ($depth - 1));

        $lines = array_map(function ($item) use ($step, $depth, $iter) {
            [$status, $key, $value] = $item;
            if ($status === 'nested' || $status === 'addedNested' || $status === 'deletedNested') {
                $nestedValue = $iter($value, $depth + 2);
                return $step . STATUS_TEXT_INDEX[$status] . "$key: $nestedValue";
            }
            $formattedValue = is_array($value)
                ? $iter($value, $depth + 2)
                : formatValuePlain($value);
            return $step . STATUS_TEXT_INDEX[$status] . "$key: $formattedValue";
        }, $currentValue);

        $result = array_merge(['{'], $lines, ["{$aStep}}"]);
        return implode("\n", $result);
    };
    return $iter($diff, $depth);
}

function formatValuePlain(string|array|bool|null|int|float $value): string
{
    if (is_string($value)) {
        return $value;
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return $value;
}
