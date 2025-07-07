<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parser(array $filePath): array
{
    return match ($filePath['extension']) {
        'json' => parseJson($filePath['fileContent']),
        'yml', 'yaml' => parseYml($filePath['fileContent']),
        default => throw new \Exception("Unsupported file format: {$filePath['extension']}"),
    };
}

function parseJson(string $fileContent): array
{
    return json_decode($fileContent, true);
}

function parseYml(string $fileContent): array
{
    return Yaml::parse($fileContent);
}
