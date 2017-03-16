<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64encodeFilter;

class Base64encodeFilterTest extends BaseTest
{
    /**
     * @var Base64encodeFilter
     */
    private $base64encode;

    protected function setUp()
    {
        parent::setUp();

        $this->base64encode = new Base64encodeFilter();
    }

    public function testFilter()
    {
        $text = 'test';
        $actual = $this->base64encode->filter($text);

        $this->assertInternalType('string', $actual);
        $this->assertEquals(8, strlen($actual));
    }
}
