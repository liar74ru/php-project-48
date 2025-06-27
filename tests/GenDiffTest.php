<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function Php\Package\genDiff;

class GenDiffTest extends TestCase
{
    private string $expected;

    protected function setUp(): void
    {
        $this->expected = file_get_contents($this->getFixtureFullPath('expected.txt'));
    }

    public function getFixtureFullPath(string $fixtureName): string|false
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $parts));
    }

    public function testFlatJsonDiff(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');
        $this->assertEquals(
            trim(str_replace(["\r\n", "\r"], "\n", $this->expected)),
            trim(str_replace(["\r\n", "\r"], "\n", genDiff($file1, $file2, 'stylish')))
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
    }

    public function testFileNotFound(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('not_exists.json');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("File not found");
        genDiff($file1, $file2);
    }
}
