<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\TextFactory;

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
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\LengthFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $textMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->filterManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->lengthFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\LengthFactoryInterface')
            ->getMock();

        $this->textMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface')
            ->getMock();

        $this->textFactory = new TextFactory(
            $this->objectManagerMock,
            $this->filterManagerMock,
            $this->iteratorFactoryMock,
            $this->lengthFactoryMock
        );
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
