<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Pixel\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ChannelFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ChannelFactoryTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var ChannelFactory
     */
    private $channelFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface')
            ->getMock();

        $this->channelFactory = new ChannelFactory($this->objectManagerMock);
    }

    /**
     * @dataProvider providerInvalidArguments
     *
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @param array $channels
     */
    public function testInvalidArguments(array $channels)
    {
        $this->channelFactory->create($channels);

        // never
        $this->objectManagerMock->expects($this->never())
            ->method('create');
    }

    /**
     * @dataProvider providerValidArguments
     *
     * @param array $channels
     */
    public function testValidArguments(array $channels)
    {
        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->channelMock);


        $this->channelFactory->create($channels);
    }

    public function testGetMethodChannels()
    {
        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->channelMock);

        $this->channelFactory->create();
    }

    public function providerValidArguments()
    {
        return  [
            [[]],
            [['red']],
            [['green']],
            [['blue']],
            [['red', 'blue']],
            [['red', 'green', 'blue']],
        ];
    }

    public function providerInvalidArguments()
    {
        return  [
            [['r']],
            [['rgb']],
            [['red', 'gradientLevel']],
        ];
    }
}
