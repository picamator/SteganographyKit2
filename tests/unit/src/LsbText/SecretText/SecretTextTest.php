<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbText\SecretText;

use Picamator\SteganographyKit2\LsbText\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SecretTextTest extends BaseTest
{
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
    }

    public function testGetResource()
    {
        $secretText = $this->getSecretText();

        // text mock
        $this->textMock->expects($this->once())
            ->method('getText');

        $secretText->getResource();
    }

    public function testGetCountBit()
    {
        $textCount = 64;
        $endMarkCount = 16;

        $secretText = $this->getSecretText();

        // text mock
        $this->textMock->expects($this->once())
            ->method('getCountBit')
            ->willReturn($textCount);

        // end mark mock
        $this->endMarkMock->expects($this->once())
            ->method('count')
            ->willReturn($endMarkCount);

        $secretText->getCountBit();
        $actual = $secretText->getCountBit(); // double run to test cache

        $this->assertEquals($textCount + $endMarkCount, $actual);
    }

    /**
     * Gets secret text
     *
     * @return SecretText
     */
    private function getSecretText() : SecretText
    {
        // text mock
        $this->textMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        // endMark mock
        $this->endMarkMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        return new SecretText($this->textMock, $this->endMarkMock);
    }
}
