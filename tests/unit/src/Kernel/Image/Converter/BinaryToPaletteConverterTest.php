<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToPaletteConverter;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Entity\PixelHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class BinaryToPaletteConverterTest extends BaseTest
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
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->pixelHelper = new PixelHelper($this);

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface')
            ->getMock();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface')
            ->getMock();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->repositoryFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryFactoryInterface')
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface')
            ->getMock();

        $this->converter = new BinaryToPaletteConverter(
            $this->channelMock,
            $this->byteFactoryMock,
            $this->colorFactoryMock,
            $this->repositoryFactoryMock
        );
    }

    public function testConvert()
    {
        $channels = ['red', 'green', 'blue'];
        $channelCount = count($channels);

        $pixelCount = 10;
        $binaryTextByte = $pixelCount * $channelCount;
        $binaryText = str_repeat('01010101', $binaryTextByte);

        $pixelList = $this->pixelHelper->getPixelList($pixelCount);

        // image mock
        $this->imageMock->expects($this->exactly(3))
            ->method('getResource')
            ->willReturn($this->resourceMock);

        $this->imageMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($pixelList));

        // resource mock
        $this->resourceMock->expects($this->exactly(2))
            ->method('getSize')
            ->willReturn($this->sizeMock);

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

        $this->channelMock->expects($this->once())
            ->method('getChannels')
            ->willReturn($channels);

        // repository factory mock
        $this->repositoryFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->repositoryMock);

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
        /** @var  $item \PHPUnit_Framework_MockObject_MockObject */
        foreach($pixelList as $item) {
            $item->expects($this->once())
                ->method('setColor')
                ->with($this->equalTo($this->colorMock));
        }

        $this->converter->convert($this->imageMock, $binaryText);
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

        // image mock
        $this->imageMock->expects($this->exactly(2))
            ->method('getResource')
            ->willReturn($this->resourceMock);

        // resource mock
        $this->resourceMock->expects($this->exactly(2))
            ->method('getSize')
            ->willReturn($this->sizeMock);

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
        $this->imageMock->expects($this->never())
            ->method('getIterator');

        $this->channelMock->expects($this->never())
            ->method('getChannels');

        $this->repositoryFactoryMock->expects($this->never())
            ->method('create');

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

        $this->converter->convert($this->imageMock, $binaryText);
    }
}
