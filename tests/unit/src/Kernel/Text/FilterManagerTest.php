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

    public function testApply()
    {
        $text = 'test';

        // filter mock
        $filterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface')
            ->getMock();

        $filterMock->expects($this->once())
            ->method('filter')
            ->willReturn($text);

        $this->filterManager->addFilter($filterMock);

        $actual = $this->filterManager->apply($text);
        $this->assertEquals($text, $actual);
    }
}
