<?php

namespace Php\Package;

function getFileData(string $filePath): array
{
    if (!file_exists($filePath)) {
        throw new \Exception("File not found: " . $filePath);
    }

    return ['fileContent' => file_get_contents($filePath),
            'extension' => pathinfo($filePath, PATHINFO_EXTENSION)
        ];
}
