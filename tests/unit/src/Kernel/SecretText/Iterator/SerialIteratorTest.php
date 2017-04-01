<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText\Iterator;

use Picamator\SteganographyKit2\Kernel\SecretText\Iterator\SerialIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialIteratorTest extends BaseTest
{
    public function testIterator()
    {
        $byteCount = 8;
        $binaryText = str_repeat('01010101', $byteCount);

        $iterator = new SerialIterator($binaryText);

        $actual = '';
        $i = 0;
        foreach($iterator as $item) {
            $actual .= $item;
            $i++;
        }

        $this->assertEquals($byteCount * 8, $i);
        $this->assertEquals($binaryText, $actual);
    }
}
