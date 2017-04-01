<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Builder\TextFactory;

class TextFactoryTest extends BaseTest
{
    /**
     * @var TextFactory
     */
    private $textFactory;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $filterManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\Data\TextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $textMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->filterManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface')
            ->getMock();

        $this->textMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Data\TextInterface')
            ->getMock();

        $this->textFactory = new TextFactory($this->objectManagerMock, $this->filterManagerMock);
    }

    public function testCreate()
    {
        $text = 'Hello Steganography!';

        // filter manager mock
        $this->filterManagerMock->expects($this->once())
            ->method('apply')
            ->with($this->equalTo($text))
            ->willReturn($text);

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->textMock);

        $this->textFactory->create($text);
    }
}
