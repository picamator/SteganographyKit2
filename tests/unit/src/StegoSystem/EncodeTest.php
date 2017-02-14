<?php
namespace Picamator\SteganographyKit2\Tests\Unit\StegoSystem;

use Picamator\SteganographyKit2\StegoSystem\Encode;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Tests\Unit\Helper\Entity\PixelHelper;
use Picamator\SteganographyKit2\Tests\Unit\Helper\RecursiveIteratorHelper;

class EncodeTest extends BaseTest
{
    /**
     * @var Encode
     */
    private $encode;

    /**
     * @var RecursiveIteratorHelper
     */
    private $recursiveIteratorHelper;

    /**
     * @var PixelHelper
     */
    private $pixelHelper;

    /**
     * @var \Picamator\SteganographyKit2\StegoSystem\Api\EncodeBitInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $encodeBitMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\StegoText\Api\StegoTextFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $stegoTextFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $stegoTextMock;

    /**
     * @var \Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\Data\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->recursiveIteratorHelper = new RecursiveIteratorHelper($this);
        $this->pixelHelper = new PixelHelper($this);

        $this->encodeBitMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\EncodeBitInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\ColorFactoryInterface')
            ->getMock();

        $this->stegoTextFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoText\Api\StegoTextFactoryInterface')
            ->getMock();

        $this->stegoTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ImageInterface')
            ->getMock();

        $this->encode = new Encode($this->encodeBitMock,  $this->colorFactoryMock, $this->stegoTextFactoryMock);
    }

    public function testEncode()
    {
        $secretText = [1, 1, 1, 1, 1, 1, 1, 1];
        $pixelCount = 3;

        // secret text mock
        $this->secretTextMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($secretText));

        // cover text mock
        $coverTextMock = $this->recursiveIteratorHelper
            ->getRecursiveIteratorMock(
                'Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface',
                $this->pixelHelper->getPixelList($pixelCount)
            );

        $coverTextMock->expects($this->once())
            ->method('getImage')
            ->willReturn($this->imageMock);

        // color mock
        $colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        // color factory mock
        $this->colorFactoryMock->expects($this->exactly($pixelCount))
            ->method('create')
            ->willReturn($colorMock);

        // encode bit mock
        $this->encodeBitMock->expects($this->exactly(count($secretText)))
            ->method('encode');

        // stego text factory mock
        $this->stegoTextFactoryMock->expects($this->once())
            ->method('create')->with($this->equalTo($this->imageMock))
            ->willReturn($this->stegoTextMock);

        $this->encode->encode($this->secretTextMock, $coverTextMock);
    }
}
