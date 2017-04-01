<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\FilterManager;

class FilterManagerTest extends BaseTest
{
    /**
     * @var FilterManager
     */
    private $filterManager;

    protected function setUp()
    {
        parent::setUp();

        $this->filterManager = new FilterManager();
    }

    public function testAttach()
    {
        $text = 'test';

        // filter mock
        $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
            ->getMock();

        $filterMock->expects($this->once())
            ->method('filter')
            ->with($this->equalTo($text))
            ->willReturn($text);

        $this->filterManager->attach($filterMock);

        $actual = $this->filterManager->apply($text);
        $this->assertEquals($text, $actual);
    }

    public function testAttachAll()
    {
        $filterCount = 10;

        $filterList = [];
        for($i = 0; $i < $filterCount; $i++) {
            // filter mock
            $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
                ->getMock();
            $filterList[] = $filterMock;
        }

        $this->filterManager->attachAll($filterList);
        $this->assertEquals($filterCount, $this->filterManager->count());
    }

    public function testDetach()
    {
        // filter mock
        $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
            ->getMock();

        // never
        $filterMock->expects($this->never())
            ->method('filter');

        $this->filterManager->attach($filterMock);
        $this->filterManager->detach($filterMock);

        $actual = $this->filterManager->count();
        $this->assertEquals(0, $actual);
    }

    public function testGetList()
    {
        $expected = [];
        for($i = 0; $i < 10; $i++) {
            // filter mock
            $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
                ->getMock();

            $this->filterManager->attach($filterMock);
            $expected[] = $filterMock;
        }

        $actual = $this->filterManager->getList();
        $this->assertSame($expected, $actual);
    }

    public function testRemoveAll()
    {
        for($i = 0; $i < 10; $i++) {
            // filter mock
            $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
                ->getMock();

            $this->filterManager->attach($filterMock);
        }

        $this->filterManager->removeAll();
        $this->assertSame(0, $this->filterManager->count());
    }

    public function testCount()
    {
        $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
            ->getMock();

        $this->filterManager->attach($filterMock);
        $this->filterManager->attach($filterMock);

        $this->assertSame(1, $this->filterManager->count());
    }
}
