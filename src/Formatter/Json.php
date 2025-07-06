<?php

namespace Differ\Formatter\Json;

function jsonFormat(array $diff): string
{
    $convert = function ($item) use (&$convert) {
        [$status, $key, $value] = $item;
        return [
            'status' => $status,
            'key' => $key,
            'value' => ($status === 'nested' || $status === 'addedNested' || $status === 'deletedNested')
                ? array_map($convert, $value)
                : $value,
        ];
    };
    $formattedDiff = array_map($convert, $diff);
    return json_encode($formattedDiff, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
}
