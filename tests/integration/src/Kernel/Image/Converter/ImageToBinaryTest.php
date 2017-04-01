<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Converter\ImageToBinary;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\Channel;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;

class ImageToBinaryTest extends BaseTest
{
    /**
     * @var ImageToBinary
     */
    private $converter;

    /**
     * @var array
     */
    private $channelList;

    /**
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * @var Channel
     */
    private $channel;

    protected function setUp()
    {
        parent::setUp();

        $this->channelList = ['red', 'green', 'blue'];

        // helper
        $this->imageHelper = new ImageHelper(
            'Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIterator',
            'Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIterator',
            $this->channelList
        );

        $this->channel = new Channel($this->channelList);

        $this->converter = new ImageToBinary($this->channel);
    }

    /**
     * @dataProvider providerConvertJpeg
     *
     * @param int $width
     * @param int $height
     * @param string $path
     */
    public function testConvertJpeg(int $width, int $height, string $path)
    {
        $path = $this->getPath($path);
        $sizeBit = $width * $height * count($this->channelList) * 8;

        $image = $this->imageHelper->getJpegImage($path);

        $actual = $this->converter->convert($image);

        $this->assertEquals($sizeBit, strlen($actual));
        $this->assertNotRegExp('/[^01]+/', $actual);
    }

    public function providerConvertJpeg()
    {
        return [
            [25, 1, 'secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            [1, 25, 'secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }
}
