<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbText\SecretText;

use Picamator\SteganographyKit2\LsbText\SecretText\Decode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class DecodeTest extends BaseTest
{
    /**
     * @var Decode
     */
    private $decode;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $filterManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    protected function setUp()
    {
        parent::setUp();

        $this->filterManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->decode = new Decode($this->filterManagerMock);
    }

    public function testDecode()
    {
        $data = '01010101';

        // secret text mock
        $this->secretTextMock->expects($this->once())
            ->method('getBinaryText')
            ->willReturn($data);

        // filter manager mock
        $this->filterManagerMock->expects($this->once())
            ->method('apply')
            ->with($this->equalTo($data))
            ->willReturn($data);

        $this->decode->decode($this->secretTextMock);
    }
}
