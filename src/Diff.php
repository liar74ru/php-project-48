<?php

namespace Differ\Diff;

const STATUS_ADDED = 'added';
const STATUS_DELETED = 'deleted';
const STATUS_UPDATE_DELETED = 'updateDeleted';
const STATUS_UPDATE_ADDED = 'updateAdded';
const STATUS_UNCHANGED = 'unchanged';
const STATUS_NESTED = 'nested';
const STATUS_ADDED_NESTED = 'addedNested';
const STATUS_DELETED_NESTED = 'deletedNested';

use function Funct\Collection\sortBy;

function unchanged(array $data): array
{
    return array_map(
        function ($value, $key) {
            return [
                is_array($value) ? STATUS_NESTED : STATUS_UNCHANGED,
                $key,
                is_array($value) ? unchanged($value) : $value
            ];
        },
        $data,
        array_keys($data)
    );
}

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
                        [STATUS_NESTED, $key, diff($firstData[$key], $secondData[$key])]
                    ],
                    $firstData[$key] !== $secondData[$key] => [
                        [STATUS_UPDATE_DELETED, $key, is_array($firstData[$key])
                            ? unchanged($firstData[$key])
                            : $firstData[$key]],
                        [STATUS_UPDATE_ADDED, $key, is_array($secondData[$key])
                            ? unchanged($secondData[$key])
                            : $secondData[$key]]
                    ],
                    default => [[STATUS_UNCHANGED, $key, $firstData[$key]]]
                },
                [true, false] => [
                    is_array($firstData[$key])
                        ? [STATUS_DELETED_NESTED, $key, unchanged($firstData[$key])]
                        : [STATUS_DELETED, $key, $firstData[$key]]
                ],
                [false, true] => [
                    is_array($secondData[$key])
                        ? [STATUS_ADDED_NESTED, $key, unchanged($secondData[$key])]
                        : [STATUS_ADDED, $key, $secondData[$key]]
                ],
                [false, false] => [] // Этот case добавлен для полноты, хотя никогда не сработает
            }
        ],
        []
    );
}
