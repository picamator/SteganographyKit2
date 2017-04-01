<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image;

use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;

class ImageTest extends BaseTest
{
    /**
     * @var ImageHelper
     */
    private $imageHelper;

    protected function setUp()
    {
        parent::setUp();

        // helper
        $this->imageHelper = new ImageHelper();
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

        // size
        $size = $image->getInfo()->getSize();
        $imageSize = $size->getHeight() * $size->getWidth();
        $this->assertGreaterThan(0, $imageSize);

        // iteration
        $i = 0;
        /** @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface $item */
        foreach ($image as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface', $item);

            $id = $item->getId();
            $this->assertNotEmpty($id);

            $color = $item->getColor()->toString();
            $this->assertNotEmpty($color);

            $i++;
        }
        $this->assertEquals($imageSize, $i);
    }

    public function providerSerialIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }
}
