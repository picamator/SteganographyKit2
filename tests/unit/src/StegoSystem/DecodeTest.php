<?php
namespace Picamator\SteganographyKit2\Tests\Unit\StegoSystem;

use Picamator\SteganographyKit2\StegoSystem\Decode;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Tests\Helper\Entity\PixelHelper;
use Picamator\SteganographyKit2\Tests\Helper\RecursiveIteratorHelper;

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
     * @var \Picamator\SteganographyKit2\SecretText\Api\SecretTextFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    /**
     * @var \Picamator\SteganographyKit2\StegoSystem\Api\DecodeBitInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $decodeBitMock;

    /**
     * @var \Picamator\SteganographyKit2\SecretText\Api\EndMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $endMarkMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->recursiveIteratorHelper = new RecursiveIteratorHelper($this);
        $this->pixelHelper = new PixelHelper($this);

        $this->secretTextFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\SecretTextFactoryInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->decodeBitMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\DecodeBitInterface')
            ->getMock();

        $this->endMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\EndMarkInterface')
            ->getMock();

        $this->decode = new Decode($this->secretTextFactoryMock, $this->decodeBitMock, $this->endMarkMock);
    }

    public function testDecode()
    {
        $pixelCount = 50;
        $endMark = '000000000000';

        // stego text mock
        $stegoTextMock = $this->recursiveIteratorHelper->getRecursiveIteratorMock(
            'Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface',
            $this->pixelHelper->getPixelList($pixelCount)
        );

        // end mark mock
        $this->endMarkMock->expects($this->once())
            ->method('getBinary')
            ->willReturn($endMark);

        $this->endMarkMock->expects($this->once())
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
