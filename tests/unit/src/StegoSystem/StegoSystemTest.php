<?php
namespace Picamator\SteganographyKit2\Tests\Unit\StegoSystem;

use Picamator\SteganographyKit2\StegoSystem\StegoSystem;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class StegoSystemTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\StegoSystem\Api\EncodeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $encodeMock;

    /**
     * @var \Picamator\SteganographyKit2\StegoSystem\Api\DecodeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $decodeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->encodeMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\EncodeInterface')
            ->getMock();

        $this->decodeMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\DecodeInterface')
            ->getMock();
    }

    public function testEncode()
    {
        // secret text mock
        $secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface')
            ->getMock();

        // cover text mock
        $coverTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface')
            ->getMock();

        // stego text mock
        $stegoTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface')
            ->getMock();

        // encode mock
        $this->encodeMock->expects($this->once())
            ->method('encode')
            ->with($this->equalTo($secretTextMock), $this->equalTo($coverTextMock))
            ->willReturn($stegoTextMock);

        // stego system mock
        $stegoSystemMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\StegoSystem')
            ->setConstructorArgs([$this->encodeMock, $this->decodeMock])
            ->setMethods(['notify'])
            ->getmock();

        $stegoSystemMock->expects($this->exactly(2))
            ->method('notify')
            ->withConsecutive(
                ['beforeEncode', $secretTextMock, $coverTextMock],
                ['afterEncode', $stegoTextMock]
            );

        $stegoSystemMock->encode($secretTextMock, $coverTextMock);
    }

    public function testDecode()
    {
        // stego text mock
        $stegoTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface')
            ->getMock();

        // secret text mock
        $secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface')
            ->getMock();

        // decode mock
        $this->decodeMock->expects($this->once())
            ->method('decode')
            ->with($this->equalTo($stegoTextMock))
            ->willReturn($secretTextMock);

        // stego system mock
        $stegoSystemMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\StegoSystem')
            ->setConstructorArgs([$this->encodeMock, $this->decodeMock])
            ->setMethods(['notify'])
            ->getmock();

        $stegoSystemMock->expects($this->exactly(2))
            ->method('notify')
            ->withConsecutive(
                ['beforeDecode', $stegoTextMock],
                ['afterDecode', $secretTextMock]
            );

        $stegoSystemMock->decode($stegoTextMock);
    }

    public function testNotify()
    {
        // observer a mock
        $observerAMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\ObserverInterface')
            ->getMock();

        $observerAMock->expects($this->never())
            ->method('update');

        // observer b mock
        $observerBMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\Api\ObserverInterface')
            ->getMock();

        $observerBMock->expects($this->once())
            ->method('update');

        $stegoSystem = new StegoSystem($this->encodeMock, $this->decodeMock);
        $stegoSystem
            ->attach('a', $observerAMock)
            ->attach('b', $observerBMock)
            ->detach('a', $observerAMock);

        $stegoSystem->notify('a');
        $stegoSystem->notify('b');

        // make observer list empty
        $stegoSystem->detach('b', $observerBMock)
            ->notify('b');
    }

    public function testNullNotify()
    {
        // stego system mock
        $stegoSystemMock = $this->getMockBuilder('Picamator\SteganographyKit2\StegoSystem\StegoSystem')
            ->setConstructorArgs([$this->encodeMock, $this->decodeMock])
            ->setMethods(['getObserverList', 'update'])
            ->getMock();

        // never
        $stegoSystemMock->expects($this->never())
            ->method('getObserverList');

        $stegoSystemMock->expects($this->never())
            ->method('update');
        
        $stegoSystemMock->notify('a');
    }
}
