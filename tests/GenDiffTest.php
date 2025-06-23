<?php

use PHPUnit\Framework\TestCase;
use function Php\Package\genDiff;

class GenDiffTest extends TestCase
{
    public function testFlatJsonDiff()
    {
        $file1 = __DIR__ . '/fixtures/file1.json';
        $file2 = __DIR__ . '/fixtures/file2.json';
        $expected = <<<EOT
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}\n
EOT;
        $this->assertEquals(
            str_replace(["\r\n", "\r"], "\n", $expected),
            str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2))
        );
    }
    
    public function testFileNotFound()
    {
        $file1 = __DIR__ . '/fixtures/file1.json';
        $file2 = __DIR__ . '/fixtures/not_exists.json';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("File not found");
        genDiff($file1, $file2);
    }
}