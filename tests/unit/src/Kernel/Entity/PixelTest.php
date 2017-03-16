<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Pixel;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PixelTest extends BaseTest
{
    /**
     * @var Pixel
     */
    private $pixel;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \RecursiveIterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('RecursiveIterator')
            ->getMock();

        $this->pixel = new Pixel($this->pointMock, $this->colorMock, $this->iteratorFactoryMock);
    }

    public function testGetId()
    {
        $x = 10;
        $y = 20;

        // point mock
        $this->pointMock->expects($this->once())
            ->method('getX')
            ->willReturn($x);

        $this->pointMock->expects($this->once())
            ->method('getY')
            ->willReturn($y);

        $actual = $this->pixel->getId();
        $this->pixel->getId(); // double run to test caching

        $this->assertEquals($x . $y, $actual);
    }

    public function testGetIterator()
    {
        // iterator factory mock
        $this->iteratorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->iteratorMock);

        $this->pixel->getIterator();
        $this->pixel->getIterator(); // double run to test caching
    }

    public function testChanged()
    {
        // color mock
        $this->colorMock->expects($this->once())
            ->method('toString')
            ->willReturn('010101010101010101010101010101010101010101010100');

        // changed color mock
        $changedColorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $changedColorMock->expects($this->once())
            ->method('toString')
            ->willReturn('010101010101010101010101010101010101010101010101');

        $this->pixel->setColor($changedColorMock);
        $this->assertTrue($this->pixel->hasChanged());
    }

    public function testUnChanged()
    {
        $toString = '010101010101010101010101010101010101010101010100';

        // color mock
        $this->colorMock->expects($this->once())
            ->method('toString')
            ->willReturn($toString);

        // changed color mock
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->expects($this->once())
            ->method('toString')
            ->willReturn($toString);

        $this->pixel->setColor($colorMock);
        $this->assertFalse($this->pixel->hasChanged());
    }
}
