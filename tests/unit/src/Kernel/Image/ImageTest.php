<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\IteratorHelper;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ImageTest extends BaseTest
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var IteratorHelper
     */
    private $iteratorHelper;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Iterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        // helpers
        $this->iteratorHelper = new IteratorHelper($this);

        $this->repositoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->iteratorHelper->getIteratorMock('Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorInterface', []);

        $this->image = new Image(
            $this->repositoryMock,
            $this->iteratorFactoryMock
        );
    }

    public function testGetIterator()
    {
        // iterator factory mock
        $this->iteratorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->iteratorMock);

        $this->image->getIterator();
        $this->image->getIterator(); // double runt to test cache
    }
}
