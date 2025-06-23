<?php

namespace Php\Package;

class FileParser
{
    private $filePath;
    
    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: " . $filePath);
        }
        $this->filePath = $filePath;
    }

    public function parse()
    {
    
        $fileContent = file_get_contents($this->filePath);

        if ($fileContent === false) {
            throw new \Exception("Could not read file: " . $this->filePath);
        }

        $parsedData = json_decode($fileContent, true);
        
        return $parsedData;
    }

     public function showParserResult(): void
    {
        print_r($this->parse());
    }
}