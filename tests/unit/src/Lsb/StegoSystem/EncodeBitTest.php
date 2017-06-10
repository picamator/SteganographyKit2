<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\Tests\Unit\Lsb\BaseTest;

class EncodeBitTest extends BaseTest
{
    /**
     * @var EncodeBit
     */
    private $encodeBit;

    protected function setUp()
    {
        parent::setUp();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface')
            ->getMock();

        $this->encodeBit = new EncodeBit();
    }

    public function testEncode()
    {
        $binary = str_repeat(0, 8);
        $data = bindec($binary);

        $byte = ByteFactory::create($data);

        $secretBit = '1';
        $stegoByte = substr_replace($binary, $secretBit, -1);

        $actual = $this->encodeBit->encode($secretBit, $byte);

        $this->assertEquals($stegoByte, $actual->getBinary());
    }

    public function testSkipEncode()
    {
        $binary = str_repeat(0, 8);
        $data = bindec($binary);

        $byte = ByteFactory::create($data);

        $secretBit = '0';

        $actual = $this->encodeBit->encode($secretBit, $byte);
        $this->assertSame($byte, $actual);
    }
}
