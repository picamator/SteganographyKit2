<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Converter\ImageToBinary;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Pixel\PixelHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ImageToBinaryTest extends BaseTest
{
    /**
     * @var ImageToBinary
     */
    private $converter;

    /**
     * @var PixelHelper
     */
    private $pixelHelper;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->pixelHelper = new PixelHelper($this);

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->converter = new ImageToBinary($this->channelMock);
    }

    public function testConvert()
    {
        $channelList = ['getRed', 'getGreen', 'getBlue'];
        $channelCount = count($channelList);

        $pixelCount = 10;
        $binaryTextByte = $pixelCount * $channelCount;
        $binaryItem = '01010101';
        $binaryText = str_repeat($binaryItem, $binaryTextByte);

        $pixelList = $this->pixelHelper->getPixelList($pixelCount);

        // channel mock
        $this->channelMock->expects($this->once())
            ->method('getMethodList')
            ->willReturn($channelList);

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($pixelList));

        // byte mock
        $this->byteMock->expects($this->exactly($binaryTextByte))
            ->method('getBinary')
            ->willReturn($binaryItem);

        // pixel mock
        /** @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject  $item */
        foreach($pixelList as $item) {

            $colorMock = $item->getColor();
            foreach($channelList as $channelItem) {
                $colorMock->expects($this->once())
                    ->method($channelItem)
                    ->willReturn($this->byteMock);
            }
        }

        $actual = $this->converter->convert($this->imageMock);
        $this->assertEquals($binaryText, $actual);
    }
}
