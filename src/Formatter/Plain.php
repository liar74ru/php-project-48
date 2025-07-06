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
    $result = array_reduce(
        $diff,
        function ($carry, $item) use ($parent) {
            [$status, $key, $value] = $item;
            $fullKey = $parent === '' ? $key : "$parent.$key";

            switch ($status) {
                case STATUS_ADDED:
                    $carry['lines'] .= "Property '$fullKey' was added with value: " . formatValue($value) . "\n";
                    break;
                case STATUS_DELETED:
                    $carry['lines'] .= "Property '$fullKey' was removed" . "\n";
                    break;
                case STATUS_UPDATE_ADDED:
                    $carry['lines'] .= "Property '$fullKey' was updated. From {$carry['lastDeleted']} to "
                        . formatValue($value) . "\n";
                    $carry['lastDeleted'] = '';
                    break;
                case STATUS_UPDATE_DELETED:
                    $carry['lastDeleted'] = formatValue($value);
                    break;
                case STATUS_NESTED:
                    $carry['lines'] .= plainFormat($value, $fullKey);
                    break;
                case STATUS_ADDED_NESTED:
                    $carry['lines'] .= "Property '$fullKey' was added with value: [complex value]" . "\n";
                    break;
                case STATUS_DELETED_NESTED:
                    $carry['lines'] .= "Property '$fullKey' was removed" . "\n";
                    break;
                case STATUS_UNCHANGED:
                    break;
            }
            return $carry;
        },
        ['lines' => '', 'lastDeleted' => '']
    );
    return $result['lines'];
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
