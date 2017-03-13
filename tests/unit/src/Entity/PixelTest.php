<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Entity;

use Picamator\SteganographyKit2\Entity\Pixel;
use Picamator\SteganographyKit2\Tests\Helper\Util\OptionsResolverHelper;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class PixelTest extends BaseTest
{
    /**
     * @var Pixel
     */
    private $pixel;

    /**
     * @var OptionsResolverHelper
     */
    private $optionsResolverHelper;

    /**
     * @var \Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Iterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('Iterator')
            ->getMock();

        // stub options resolver
        $this->optionsResolverHelper = new OptionsResolverHelper($this);

        $options = [
            'point' => $this->pointMock,
            'color' => $this->colorMock,
            'iteratorFactory' => $this->iteratorFactoryMock,
        ];
        $optionsResolverMock = $this->optionsResolverHelper->stubOptionsResolver($options);

        $this->pixel = new Pixel($optionsResolverMock, $options);
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
        $changedColorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
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
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->expects($this->once())
            ->method('toString')
            ->willReturn($toString);

        $this->pixel->setColor($colorMock);
        $this->assertFalse($this->pixel->hasChanged());
    }
}
