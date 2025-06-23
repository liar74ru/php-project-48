<?php

namespace Php\Package;

function parseJson(string $filePath): array
{
    $fileContent = file_get_contents($filePath);

    $parsedData = json_decode($fileContent, true);

    return $parsedData;
}

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

function genDiff($firstFile, $secondFile): string
{
    if (!file_exists($firstFile) || !file_exists($secondFile)) {
        throw new \Exception("File not found: " . $firstFile . " or " . $secondFile);
    }
    $values = diff(parseJson($firstFile), parseJson($secondFile));
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
