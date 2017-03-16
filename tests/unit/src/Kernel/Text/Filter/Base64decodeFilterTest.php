<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64decodeFilter;

class Base64decodeFilterTest extends BaseTest
{
    /**
     * @var Base64decodeFilter
     */
    private $base64decode;

    protected function setUp()
    {
        parent::setUp();

        $this->base64decode = new Base64decodeFilter();
    }

    public function testFilter()
    {
        $expected = 'test';
        $text = base64_encode($expected);

        $actual = $this->base64decode->filter($text);

        $this->assertEquals($expected, $actual);
    }
}
