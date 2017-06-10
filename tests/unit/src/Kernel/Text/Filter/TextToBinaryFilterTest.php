<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Filter\TextToBinaryFilter;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class TextToBinaryFilterTest extends BaseTest
{
    /**
     * @var TextToBinaryFilter
     */
    private $filter;

    protected function setUp()
    {
        parent::setUp();

        $this->filter = new TextToBinaryFilter();
    }

    /**
     * @dataProvider providerFilter
     *
     * @param string $text
     */
    public function testFilter(string $text)
    {
        $textSplited = str_split($text);
        $binaryContainer = [];
        foreach($textSplited as $item) {
            $binaryContainer[] = sprintf('%08d',  decbin(ord($item)));
        }

        $actual = $this->filter->filter($text);
        $this->assertEquals(implode('', $binaryContainer), $actual);
    }

    public function providerFilter()
    {
        return [
            ['Hello Steganography!'],
        ];
    }
}
