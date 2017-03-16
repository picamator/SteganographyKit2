<?php
namespace Picamator\SteganographyKit2\Tests\Unit\SecretText;

use Picamator\SteganographyKit2\SecretText\EndMark;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class EndMarkTest extends BaseTest
{
    public function testIteration()
    {
        $endMark = new EndMark();

        $i = 0;
        foreach($endMark as $item) {
            $this->assertEquals(1, strlen($item));
            $this->assertEquals(0, preg_match('/[^01]+/', $item));
            $i++;
        }
        $this->assertEquals($endMark->count(), $i);
    }

    /**
     * @dataProvider providerInvalidEndMark
     *
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     *
     * @param string $endMark
     */
    public function testInvalidEndMark(string $endMark)
    {
        new EndMark($endMark);
    }

    public function providerInvalidEndMark()
    {
        return [
            ['0101010101'],
            ['1234567a']
        ];
    }
}
