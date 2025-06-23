<?php

namespace Php\Package;

function parse($filePath): array
    {
        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            throw new \Exception("Could not read file: " . $this->filePath);
        }

        $parsedData = json_decode($fileContent, true);
        
        return $parsedData;
    }

function showParserResult($filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: " . $filePath);
        }
        print_r(parse($filePath));
    }