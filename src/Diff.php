<?php

namespace Php\Package;

use function Funct\Collection\sortBy;

function diff(array $firstData, array $secondData): array
{
    $keys = array_unique(array_merge(array_keys($firstData), array_keys($secondData)));
    $sortedKeys = sortBy($keys, fn($key) => $key);

    return array_reduce(
        $sortedKeys,
        fn($diff, $key) => [
            ...$diff,
            ...match (
                [
                array_key_exists($key, $firstData),
                array_key_exists($key, $secondData)
                ]
            ) {
                [true, true] => match (true) {
                    is_array($firstData[$key]) && is_array($secondData[$key]) => [
                        ['nested', $key, diff($firstData[$key], $secondData[$key])]
                    ],
                    $firstData[$key] !== $secondData[$key] => [
                        ['updateDeleted', $key, is_array($firstData[$key])
                            ? diff($firstData[$key], $firstData[$key])
                            : $firstData[$key]],
                        ['updateAdded', $key, is_array($secondData[$key])
                            ? diff($secondData[$key], $secondData[$key])
                            : $secondData[$key]]
                    ],
                    default => [['unchanged', $key, $firstData[$key]]]
                },
                [true, false] => [
                    is_array($firstData[$key])
                        ? ['deletedNested', $key, diff($firstData[$key], $firstData[$key])]
                        : ['deleted', $key, $firstData[$key]]
                ],
                [false, true] => [
                    is_array($secondData[$key])
                        ? ['addedNested', $key, diff($secondData[$key], $secondData[$key])]
                        : ['added', $key, $secondData[$key]]
                ]
            }
        ],
        []
    );
}
