<?php

namespace Php\Package;

function diff(array $firstData, array $secondData): array
{
    $diff = [];
    $keys = array_unique(array_merge(array_keys($firstData), array_keys($secondData)));
    sort($keys);

    foreach ($keys as $key) {
        $inFirst = array_key_exists($key, $firstData);
        $inSecond = array_key_exists($key, $secondData);

        if ($inFirst && $inSecond) {
            $firstValue = $firstData[$key];
            $secondValue = $secondData[$key];

            if (is_array($firstValue) && is_array($secondValue)) {
                $nestedDiff = diff($firstValue, $secondValue);
                $diff[] = ['nested', $key, $nestedDiff];
            } elseif ($firstValue !== $secondValue) {
                $diff[] = ['deleted', $key, is_array($firstValue) ? diff($firstValue, $firstValue) : $firstValue];
                $diff[] = ['added', $key, is_array($secondValue) ? diff($secondValue, $secondValue) : $secondValue];
            } else {
                $diff[] = ['unchanged', $key, $firstValue];
            }
        } elseif ($inFirst) {
            $value = $firstData[$key];
            if (is_array($value)) {
                $diff[] = ['deletedNested', $key, diff($value, $value)];
            } else {
                $diff[] = ['deleted', $key, $value];
            }
        } elseif ($inSecond) {
            $value = $secondData[$key];
            if (is_array($value)) {
                $diff[] = ['addedNested', $key, diff($value, $value)];
            } else {
                $diff[] = ['added', $key, $value];
            }
        }
    }

    return $diff;
}
