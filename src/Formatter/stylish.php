<?php

namespace Php\Package;

use function Php\Package\parseJson;
use function Php\Package\parseYml;

function diff(array $firstData, array $secondData): array
{
    $diff = [];
    $keys = array_unique(array_merge(array_keys($firstData), array_keys($secondData)));
    sort($keys);

    foreach ($keys as $key) {
        if (array_key_exists($key, $firstData)) {
            if (array_key_exists($key, $secondData)) {
                if ($firstData[$key] !== $secondData[$key]) {
                    $diff["- $key"] = $firstData[$key];
                    $diff["+ $key"] = $secondData[$key];
                } else {
                    $diff["  $key"] = $firstData[$key];
                }
            } else {
                    $diff["- $key"] = $firstData[$key];
            }
        } elseif (array_key_exists($key, $secondData)) {
            $diff["+ $key"] = $secondData[$key];
        }
    }
    return $diff;
}

function stylishFormat(array $firstFile, array $secondFile): string
{
    $values = diff($firstFile, $secondFile);
    $result = "{\n";
    foreach ($values as $key => $value) {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        $result .= "  $key: $value\n";
    }
    $result .= "}\n";

    return $result;
}
