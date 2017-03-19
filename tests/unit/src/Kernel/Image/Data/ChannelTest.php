<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Data;

use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ChannelTest extends BaseTest
{
    /**
     * @dataProvider providerInvalidArguments
     *
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @param array $channels
     */
    public function testInvalidArguments(array $channels)
    {
        new Channel($channels);
    }

    /**
     * @dataProvider providerValidArguments
     *
     * @param array $channels
     */
    public function testValidArguments(array $channels)
    {
        $actualCount = count($channels);
        $actualCount = $actualCount === 0 ? 3 : $actualCount;

        $actualChannel = new Channel($channels);
        $actualChannelList = $actualChannel->getChannels();
        $actualChannelMethodList = $actualChannel->getMethodChannels();

        $this->assertNotEmpty($actualChannelList);
        $this->assertNotEmpty($actualChannelMethodList);
        $this->assertEquals($actualCount, $actualChannel->count());
        $this->assertEquals(count($actualChannelMethodList), $actualChannel->count());
    }


    public function testGetMethodChannels()
    {
        $channel = new Channel();
        $methodList = $channel->getMethodChannels();

        foreach($methodList as $item) {
            $this->assertTrue(method_exists('Picamator\SteganographyKit2\Kernel\Image\Data\Color', $item));
        }
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
