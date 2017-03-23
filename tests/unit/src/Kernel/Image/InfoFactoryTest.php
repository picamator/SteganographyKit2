<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\InfoFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class InfoFactoryTest extends BaseTest
{
    /**
     * @var InfoFactory
     */
    private $infoFactory;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->sizeFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\InfoInterface')
            ->getMock();

        $this->infoFactory = new InfoFactory($this->objectManagerMock, $this->sizeFactoryMock);
    }

    /**
     * @dataProvider providerCreate
     *
     * @param string $path
     */
    public function testCreate(string $path)
    {
        $path = $this->getPath($path);

        // size factory mock
        $this->sizeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->sizeMock);

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->infoMock);

        $this->infoFactory->create($path);
    }

    public function providerCreate()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg']
        ];
    }
}
