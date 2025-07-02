<?php

namespace Php\Package;

function jsonFormat(array $diff): string
{
    $convert = function ($item) use (&$convert) {
        [$status, $key, $value] = $item;
        if (is_array($value) && ($status === 'nested' || $status === 'addedNested' || $status === 'deletedNested')) {
            $value = array_map($convert, $value);
        }
        return [
            'status' => $status,
            'key' => $key,
            'value' => $value,
        ];
    };
    $formattedDiff = array_map($convert, $diff);
    return json_encode($formattedDiff, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
}