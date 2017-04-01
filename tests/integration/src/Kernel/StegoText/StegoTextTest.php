<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\StegoText;

use Picamator\SteganographyKit2\Kernel\StegoText\StegoText;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;

class StegoTextTest extends BaseTest
{
    /**
     * @var array
     */
    private $channelList;

    /**
     * @var ImageHelper
     */
    private $imageHelper;

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
    }

    /**
     * @dataProvider providerSerialIteratorJpeg
     *
     * @param string $path
     */
    public function testSerialIteratorJpeg(string $path)
    {
        $path = $this->getPath($path);

        $image = $this->imageHelper->getJpegImage($path);

        $size = $image->getInfo()->getSize();
        $sizeImage = $size->getHeight() * $size->getWidth();

        $stegoText = new StegoText($image);
        $iterator = new \RecursiveIteratorIterator($stegoText);

        // iteration
        $i = 0;
        /** @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface $item */
        foreach ($iterator as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface', $item);

            $id = $item->getInt();
            $this->assertInternalType('int', $id);
            $this->assertLessThanOrEqual(255, $id);

            $i++;
        }
        $this->assertEquals($sizeImage * 3, $i);
    }

    public function providerSerialIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }
}
