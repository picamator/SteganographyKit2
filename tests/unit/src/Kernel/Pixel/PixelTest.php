<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Pixel;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\RecursiveIteratorHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PixelTest extends BaseTest
{
    /**
     * @var Pixel
     */
    private $pixel;

    /**
     * @var RecursiveIteratorHelper
     */
    private $recursiveIteratorHelper;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->recursiveIteratorHelper = new RecursiveIteratorHelper($this);

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->recursiveIteratorHelper->getRecursiveIteratorMock('Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorInterface', []);

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
        $changedColorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
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
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->expects($this->once())
            ->method('toString')
            ->willReturn($toString);

        $this->pixel->setColor($colorMock);
        $this->assertFalse($this->pixel->hasChanged());
    }

    public function testIdenticalColor()
    {
        // never
        $this->colorMock->expects($this->never())
            ->method('toString');

        $this->pixel->setColor($this->colorMock);
        $this->assertFalse($this->pixel->hasChanged());
    }
}
