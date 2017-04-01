<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;

class BinaryToTextFilterTest extends BaseTest
{
    /**
     * @var BinaryToTextFilter
     */
    private $filter;

    protected function setUp()
    {
        parent::setUp();

        $this->filter = new BinaryToTextFilter();
    }

    /**
     * @dataProvider providerFilter
     *
     * @param string $text
     */
    public function testFilter(string $text)
    {
        $textSplited = str_split($text);
        $binaryText= '';
        foreach($textSplited as $item) {
            $binaryText .= sprintf('%08d',  decbin(ord($item)));
        }

        $actual = $this->filter->filter($binaryText);

        $this->assertEquals($text, $actual);
    }

    public function providerFilter()
    {
        return [
            ['Hello Steganography!'],
        ];
    }
}
