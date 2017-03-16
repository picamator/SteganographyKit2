<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SecretTextTest extends BaseTest
{
    /**
     * @var SecretText
     */
    private $secretText;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $textMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $endMarkMock;

    /**
     * @var \Iterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->textMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface')
            ->getMock();

        $this->endMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\EndMarkInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('Iterator')
            ->getMock();

        $this->secretText = new SecretText($this->textMock, $this->endMarkMock);
    }

    public function testGetResource()
    {
        // text mock
        $this->textMock->expects($this->once())
            ->method('getText');

        $this->secretText->getResource();
    }

    public function testGetLengthBits()
    {
        // text mock
        $this->textMock->expects($this->once())
            ->method('getLengthBits')
            ->willReturn(0);

        $this->secretText->getLengthBits();
    }

    public function testGetIterator()
    {
        // text mock
        $this->textMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        // endMark mock
        $this->endMarkMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        $this->secretText->getIterator();
        $this->secretText->getIterator(); // double run to test cache
    }
}
