<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Entity\Memento;

use Picamator\SteganographyKit2\Entity\Memento\PixelCareTaker;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class PixelCareTakerTest extends BaseTest
{
    /**
     * @var PixelCareTaker
     */
    private $pixelCareTaker;

    protected function setUp()
    {
        parent::setUp();

        $this->pixelCareTaker = new PixelCareTaker();
    }

    public function testSingleAdd()
    {
        // memento mock
        $mementoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface')
            ->getMock();

        $this->pixelCareTaker->add($mementoMock);

        $this->assertFalse($this->pixelCareTaker->hasChanged());
        $this->assertEquals(1, count($this->pixelCareTaker->getList()));
    }

    public function testChanged()
    {
        // color mock
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->expects($this->exactly(2))
            ->method('toString')
            ->willReturnOnConsecutiveCalls('10', '11');

        // memento first mock
        $mementoFirstMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface')
            ->getMock();

        $mementoFirstMock->expects($this->once())
            ->method('getColor')
            ->willReturn($colorMock);

        // memento second mock
        $mementoSecondMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface')
            ->getMock();

        $mementoSecondMock->expects($this->once())
            ->method('getColor')
            ->willReturn($colorMock);

        $this->pixelCareTaker->add($mementoFirstMock);
        $this->pixelCareTaker->add($mementoSecondMock);

        $this->assertTrue($this->pixelCareTaker->hasChanged());
        $this->assertEquals(2, count($this->pixelCareTaker->getList()));
    }

    public function testNoChanged()
    {
        // color mock
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $colorMock->expects($this->exactly(2))
            ->method('toString')
            ->willReturnOnConsecutiveCalls('10', '10');

        // memento first mock
        $mementoFirstMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface')
            ->getMock();

        $mementoFirstMock->expects($this->once())
            ->method('getColor')
            ->willReturn($colorMock);

        // memento second mock
        $mementoSecondMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\Memento\PixelMementoInterface')
            ->getMock();

        $mementoSecondMock->expects($this->once())
            ->method('getColor')
            ->willReturn($colorMock);

        $this->pixelCareTaker->add($mementoFirstMock);
        $this->pixelCareTaker->add($mementoSecondMock);

        $this->assertFalse($this->pixelCareTaker->hasChanged());
        $this->assertEquals(1, count($this->pixelCareTaker->getList()));
    }
}
