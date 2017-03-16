<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipCompressFilter;

class ZipCompressFilterTest extends BaseTest
{
    /**
     * @dataProvider providerValidCompressLevel
     *
     * @param int $compressLevel
     */
    public function testValidCompressLevel(int $compressLevel)
    {
        $zipCompress = new ZipCompressFilter($compressLevel);

        $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Text\Filter\ZipCompressFilter', $zipCompress);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testInvalidCompressLevel()
    {
        new ZipCompressFilter(10);
    }

    public function testFilter()
    {
        $text = 'test';
        $zipCompress = new ZipCompressFilter();
        $actual = $zipCompress->filter($text);

        $this->assertInternalType('string', $actual);
        $this->assertEquals(12, strlen($actual));

    }

    public function providerValidCompressLevel()
    {
        return [
            [-1],
            [0],
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7],
            [8],
            [9]
        ];
    }
}
