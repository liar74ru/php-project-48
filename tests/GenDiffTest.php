<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Package\genDiff;

class GenDiffTest extends TestCase
{
    private string $expected;
    private string $plainExpected;

    protected function setUp(): void
    {
        $expectedPath = $this->getFixtureFullPath('expected.txt');
        $expected = file_get_contents($expectedPath);
        if ($expected === false) {
            throw new \Exception("Cannot read expected.txt");
        }
        $this->expected = $expected;

        $plainExpectedPath = $this->getFixtureFullPath('plain-expected.txt');
        $plainExpected = file_get_contents($plainExpectedPath);
        if ($plainExpected === false) {
            throw new \Exception("Cannot read plain-expected.txt");
        }
        $this->plainExpected = $plainExpected;
    }


    public function getFixtureFullPath(string $fixtureName): string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        $path = realpath(implode('/', $parts));
        if ($path === false) {
            throw new \Exception("Fixture not found: $fixtureName");
        }
        return $path;
    }

    public function testFlatJsonDiff(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');
        $this->assertEquals(
            trim(str_replace(["\r\n", "\r"], "\n", $this->expected)),
            trim(str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2, 'stylish')))
        );
        $this->assertEquals(
            trim(str_replace(["\r\n", "\r"], "\n", $this->plainExpected)),
            trim(str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2, 'plain')))
        );
    }

    public function testFlatYamlDiff(): void
    {
        $file1 = $this->getFixtureFullPath('file1.yml');
        $file2 = $this->getFixtureFullPath('file2.yml');
        $this->assertEquals(
            trim(str_replace(["\r\n", "\r"], "\n", $this->expected)),
            trim(str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2)))
        );
        $this->assertEquals(
            trim(str_replace(["\r\n", "\r"], "\n", $this->plainExpected)),
            trim(str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2, 'plain')))
        );
    }

    public function testFileNotFound(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = __DIR__ . '/fixtures/not_exists.json';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("File not found");
        genDiff($file1, $file2);
    }

    public function testFormatNotFound(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Unknown format");
        genDiff($file1, $file2, 'not_exists_format');
    }
}
