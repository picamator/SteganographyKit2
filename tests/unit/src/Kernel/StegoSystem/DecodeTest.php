<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Pixel\PixelHelper;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\RecursiveIteratorHelper;

class DecodeTest extends BaseTest
{
    /**
     * @var Decode
     */
    private $decode;

    /**
     * @var RecursiveIteratorHelper
     */
    private $recursiveIteratorHelper;

    /**
     * @var PixelHelper
     */
    private $pixelHelper;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeBitInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $decodeBitMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->recursiveIteratorHelper = new RecursiveIteratorHelper($this);
        $this->pixelHelper = new PixelHelper($this);

        $this->secretTextFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->decodeBitMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\StegoSystem\Api\DecodeBitInterface')
            ->getMock();

        $this->infoMarkFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->decode = new Decode($this->decodeBitMock, $this->infoMarkFactoryMock, $this->secretTextFactoryMock);
    }

    public function testDecode()
    {
        $pixelCount = 50;

        // stego text mock
        $stegoTextMock = $this->recursiveIteratorHelper->getRecursiveIteratorMock(
            'Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface',
            $this->pixelHelper->getPixelList($pixelCount)
        );

        // info mark mock
        $this->infoMarkFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->infoMarkMock);

        // info mark mock
        $this->infoMarkMock->expects($this->once())
            ->method('countText')
            ->willReturn($pixelCount * 3 - 32);

        // decode bit mock
        $this->decodeBitMock->expects($this->exactly($pixelCount * 3))
            ->method('decode')
            ->willReturn(1);

        // secret text factory mock
        $this->secretTextFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->secretTextMock);

        $this->decode->decode($stegoTextMock);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailDecode()
    {
        $pixelCount = 10;

        // stego text mock
        $stegoTextMock = $this->recursiveIteratorHelper->getRecursiveIteratorMock(
            'Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface',
            $this->pixelHelper->getPixelList($pixelCount)
        );

        // decode bit mock
        $this->decodeBitMock->expects($this->exactly($pixelCount * 3))
            ->method('decode')
            ->willReturn(1);

        // never
        $this->infoMarkFactoryMock->expects($this->never())
            ->method('create');

        $this->infoMarkMock->expects($this->never())
            ->method('countText');

        $this->secretTextFactoryMock->expects($this->never())
            ->method('create');

        $this->decode->decode($stegoTextMock);
    }
}
