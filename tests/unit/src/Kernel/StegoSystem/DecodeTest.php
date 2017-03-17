<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\StegoSystem;

use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Entity\PixelHelper;
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
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $endMarkMock;

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

        $this->endMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface')
            ->getMock();

        $this->decode = new Decode($this->secretTextFactoryMock, $this->decodeBitMock, $this->endMarkMock);
    }

    public function testDecode()
    {
        $pixelCount = 50;
        $endMark = '000000000000';

        // stego text mock
        $stegoTextMock = $this->recursiveIteratorHelper->getRecursiveIteratorMock(
            'Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface',
            $this->pixelHelper->getPixelList($pixelCount)
        );

        // end mark mock
        $this->endMarkMock->expects($this->once())
            ->method('getBinary')
            ->willReturn($endMark);

        $this->endMarkMock->expects($this->exactly(2))
            ->method('count')
            ->willReturn(strlen($endMark));

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
}
