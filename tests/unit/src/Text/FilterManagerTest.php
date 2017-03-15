<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Text\Filter;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Text\FilterManager;

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

    public function testApply()
    {
        $text = 'test';

        // filter mock
        $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Text\Api\FilterInterface')
            ->getMock();

        $filterMock->expects($this->once())
            ->method('filter')
            ->willReturn($text);

        $this->filterManager->addFilter($filterMock);

        $actual = $this->filterManager->apply($text);
        $this->assertEquals($text, $actual);
    }
}
