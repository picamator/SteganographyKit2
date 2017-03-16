<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipDecompressFilter;

class ZipDecompressFilterTest extends BaseTest
{
    /**
     * @var ZipDecompressFilter
     */
    private $zipDecompress;

    protected function setUp()
    {
        parent::setUp();

        $this->zipDecompress = new ZipDecompressFilter();
    }

    public function testFilter()
    {
        $expected = 'test';
        $text = gzcompress($expected);

        $actual = $this->zipDecompress->filter($text);
        $this->assertEquals($expected, $actual);
    }
}
