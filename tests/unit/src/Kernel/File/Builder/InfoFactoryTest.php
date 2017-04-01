<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\File\Builder\InfoFactory;
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
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\SizeFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->sizeFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\SizeFactoryInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
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
        $this->infoFactory->create($path); // double run to check internal cache
    }

    public function providerCreate()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg']
        ];
    }
}
