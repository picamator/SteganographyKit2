<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SizeFactoryTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->sizeFactory = new SizeFactory($this->objectManagerMock);
    }

    /**
     * @dataProvider providerInvalidArguments
     *
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @param int $width
     * @param int $height
     */
    public function testInvalidArguments(int $width, int $height)
    {
        $this->sizeFactory->create($width, $height);

        // never
        $this->objectManagerMock->expects($this->never())
            ->method('create');
    }

    /**
     * @dataProvider providerValidArguments
     *
     * @param int $width
     * @param int $height
     */
    public function testValidArguments(int $width, int $height)
    {
        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->sizeMock);


        $this->sizeFactory->create($width, $height);
    }

    public function providerValidArguments()
    {
        return  [
            [1, 1],
            [1, 100],
        ];
    }

    public function providerInvalidArguments()
    {
        return  [
            [0, 0],
            [0, 10],
            [-1, -10],
        ];
    }
}
