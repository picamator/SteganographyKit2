<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Text\Text;

class TextTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Text\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Text\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    /**
     * @var \Picamator\SteganographyKit2\Text\Api\LengthFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Text\Api\Data\LengthInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthMock;

    protected function setUp()
    {
        parent::setUp();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Text\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('Iterator')
            ->getMock();

        $this->lengthFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Text\Api\LengthFactoryInterface')
            ->getMock();

        $this->lengthMock = $this->getMockBuilder('Picamator\SteganographyKit2\Text\Api\Data\LengthInterface')
            ->getMock();
    }

    public function testGetLengthBits()
    {
        $data = 'test';
        $dataLengthBits = strlen($data) * 8;

        $text = new Text($this->iteratorFactoryMock, $this->lengthFactoryMock, $data);

        // length factory test
        $this->lengthFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->lengthMock);

        // length mock
        $this->lengthMock->expects($this->once())
            ->method('getLengthBits')
            ->willReturn($dataLengthBits);

        $actual = $text->getLengthBits();
        $text->getLengthBits(); // double run to test cache

        $this->assertEquals($dataLengthBits, $actual);
    }

    public function testGetIterator()
    {
        $data = 'test';
        $text = new Text($this->iteratorFactoryMock, $this->lengthFactoryMock, $data);

        // iterator factory mock
        $this->iteratorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->iteratorMock);

        $text->getIterator();
        $text->getIterator(); // double run to test cache
    }
}
