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

        $this->assertEquals($actualCount, $actualChannel->count());
        $this->assertNotEmpty($actualChannelList);
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
