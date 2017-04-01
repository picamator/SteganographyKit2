<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\InfoMark;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class InfoMarkTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @dataProvider providerInvalidWidth
     *
     * @param int $width
     */
    public function testInvalidWidth(int $width)
    {
        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        new InfoMark($this->sizeMock);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @dataProvider providerInvalidHeight
     *
     * @param int $height
     */
    public function testInvalidHeight(int $height)
    {
        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn(1);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        new InfoMark($this->sizeMock);
    }

    /**
     * @dataProvider providerGetBinary
     *
     * @param int $width
     * @param int $height
     * @param string $expected
     */
    public function testGetBinary(int $width, int $height, string $expected)
    {
        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $infoMark  = new InfoMark($this->sizeMock);
        $actual = $infoMark->getBinary();

        $this->assertEquals(32, strlen($actual));
        $this->assertEquals($expected, $actual);
    }

    public function testIterator()
    {
        $width = 10;
        $height = 10;

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $infoMark  = new InfoMark($this->sizeMock);
        $iterator = $infoMark->getIterator();

        $actual = '';
        foreach($iterator as $item) {
            $actual .= $item;
        }
        $this->assertEquals(32, strlen($actual));
    }

    /**
     * @dataProvider providerCountText
     *
     * @param int $width
     * @param int $height
     * @param int $expected
     */
    public function testCountText(int $width, int $height, int $expected)
    {
        // size mock
        $this->sizeMock->expects($this->exactly(2))
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->exactly(2))
            ->method('getHeight')
            ->willReturn($height);

        $infoMark  = new InfoMark($this->sizeMock);
        $actual = $infoMark->countText();

        $this->assertEquals($expected, $actual);
    }

    public function providerCountText()
    {
        return [
            [10, 0, 80],
            [10, 5, 10 * 5 * 3 * 8]
        ];
    }

    public function providerGetBinary()
    {
        return [
            [10, 100, '00000000000010100000000001100100'],
            [10, 0, '00000000000010100000000000000000'],
        ];
    }

    public function providerInvalidWidth()
    {
        return [
            [65536],
            [-1],
            [0],
        ];
    }

    public function providerInvalidHeight()
    {
        return [
            [65536],
            [-1],
        ];
    }
}
