<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Lsb\StegoSystem\DecodeBit;
use Picamator\SteganographyKit2\Tests\Unit\Lsb\BaseTest;

class DencodeBitTest extends BaseTest
{
    /**
     * @var DecodeBit
     */
    private $decodeBit;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    protected function setUp()
    {
        parent::setUp();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->decodeBit = new DecodeBit();
    }

    /**
     * @dataProvider providerDecode
     *
     * @param int $data
     * @param string $expected
     */
    public function testDecode(int $data, string $expected)
    {
        // byte mock
        $this->byteMock->expects($this->once())
            ->method('getInt')
            ->willReturn($data);

        $actual = $this->decodeBit->decode($this->byteMock);
        $this->assertSame($expected, $actual);
    }

    public function providerDecode()
    {
        return [
            [190, '0'],
            [191, '1']
        ];
    }
}
