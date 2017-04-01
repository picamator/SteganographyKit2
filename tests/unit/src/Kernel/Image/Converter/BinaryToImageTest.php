<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToImage;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Pixel\PixelHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class BinaryToImageTest extends BaseTest
{
    /**
     * @var BinaryToPaletteConverter
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
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Builder\InfoPaletteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->pixelHelper = new PixelHelper($this);

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface')
            ->getMock();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $this->infoFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Builder\InfoPaletteFactoryInterface')
            ->getMock();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();

        $this->imageFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface')
            ->getMock();

        $this->converter = new BinaryToImage(
            $this->channelMock,
            $this->byteFactoryMock,
            $this->colorFactoryMock,
            $this->infoFactoryMock,
            $this->imageFactoryMock
        );
    }

    public function testConvert()
    {
        $channelList = ['red', 'green', 'blue'];
        $channelCount = count($channelList);

        $pixelCount = 10;
        $binaryTextByte = $pixelCount * $channelCount;
        $binaryText = str_repeat('01010101', $binaryTextByte);

        $pixelList = $this->pixelHelper->getPixelList($pixelCount);

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($pixelCount);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn(1);

        // channel mock
        $this->channelMock->expects($this->atLeastOnce())
            ->method('count')
            ->willReturn($channelCount);

        $this->channelMock->expects($this->once())
            ->method('getChannelList')
            ->willReturn($channelList);

        // info factory mock
        $this->infoFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($this->sizeMock))
            ->willReturn($this->infoMock);

        // image factory mock
        $this->imageFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($this->infoMock))
            ->willReturn($this->imageMock);

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($this->repositoryMock);

        $this->imageMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($pixelList));

        // repository mock
        $this->repositoryMock->expects($this->exactly($pixelCount))
            ->method('insert');

        // color factory mock
        $this->colorFactoryMock->expects($this->exactly($pixelCount))
            ->method('create')
            ->willReturn($this->colorMock);

        // byte factory mock
        $this->byteFactoryMock->expects($this->exactly($binaryTextByte))
            ->method('create')
            ->willReturn($this->byteMock);

        // pixel mock
        /** @var \PHPUnit_Framework_MockObject_MockObject $item */
        foreach($pixelList as $item) {
            $item->expects($this->once())
                ->method('setColor')
                ->with($this->equalTo($this->colorMock));
        }

        $this->converter->convert($this->sizeMock, $binaryText);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testFailConvert()
    {
        $channels = ['red', 'green', 'blue'];
        $channelCount = count($channels);

        $pixelCount = 10;
        $binaryText = str_repeat('01010101', $pixelCount);

        $pixelList = $this->pixelHelper->getPixelList($pixelCount);

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($pixelCount);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn(1);

        // channel mock
        $this->channelMock->expects($this->once())
            ->method('count')
            ->willReturn($channelCount);

        // never
        $this->infoFactoryMock->expects($this->never())
            ->method('create');

        $this->imageFactoryMock->expects($this->never())
            ->method('create');

        $this->imageMock->expects($this->never())
            ->method('getIterator');

        $this->channelMock->expects($this->never())
            ->method('getChannelList');

        $this->repositoryMock->expects($this->never())
            ->method('insert');

        $this->colorFactoryMock->expects($this->never())
            ->method('create');

        $this->byteFactoryMock->expects($this->never())
            ->method('create');

        /** @var  $item \PHPUnit_Framework_MockObject_MockObject */
        foreach($pixelList as $item) {
            $item->expects($this->never())
                ->method('setColor');
        }

        $this->converter->convert($this->sizeMock, $binaryText);
    }
}
