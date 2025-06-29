<?php

namespace Php\Package;

const STATUS_ADDED = 'added';
const STATUS_DELETED = 'deleted';
const STATUS_UPDATE_DELETED = 'updateDeleted';
const STATUS_UPDATE_ADDED = 'updateAdded';
const STATUS_UNCHANGED = 'unchanged';
const STATUS_NESTED = 'nested';
const STATUS_ADDED_NESTED = 'addedNested';
const STATUS_DELETED_NESTED = 'deletedNested';

function plainFormat(array $diff, string $parent = ''): string
{
    $lines = [];
    $updateDeletedHandled = '';
    foreach ($diff as [$status, $key, $value]) {
        $fullKey = $parent === '' ? $key : "$parent.$key";
        switch ($status) {
            case STATUS_ADDED:
                $lines[] = "Property '$fullKey' was added with value: " . formatValue($value);
                break;
            case STATUS_DELETED:
                $lines[] = "Property '$fullKey' was removed";
                break;
            case STATUS_UPDATE_ADDED:
                $lines[] = "Property '$fullKey' was updated. From $updateDeletedHandled to " . formatValue($value);
                break;
            case STATUS_UPDATE_DELETED:
                $updateDeletedHandled = formatValue($value);
                break;
            case STATUS_NESTED:
                $lines[] = plainFormat($value, $fullKey);
                break;
            case STATUS_ADDED_NESTED:
                $lines[] = "Property '$fullKey' was added with value: [complex value]";
                break;
            case STATUS_DELETED_NESTED:
                $lines[] = "Property '$fullKey' was removed";
                break;
            case STATUS_UNCHANGED:
                break;
        }
    }
    return implode("\n", $lines);
}

function formatValue(string|array|bool|null|int|float $value): string
{
    if (is_string($value)) {
        return "'$value'";
    }

    if (is_array($value)) {
        return '[complex value]';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string)$value;
}
