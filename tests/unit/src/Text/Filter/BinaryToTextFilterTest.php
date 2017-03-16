<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Text\Filter\BinaryToTextFilter;

class BinaryToTextFilterTest extends BaseTest
{
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

        $filter = new BinaryToTextFilter();
        $actual = $filter->filter($binaryText);

        $this->assertEquals($text, $actual);
    }

    public function providerFilter()
    {
        return [
            ['Hello Steganography!'],
        ];
    }
}
