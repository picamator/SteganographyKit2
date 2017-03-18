<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

class ImageTest extends BaseTest
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var PointFactory
     */
    private $pointFactory;

    /**
     * @var PixelFactory
     */
    private $pixelFactory;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    protected function setUp()
    {
        parent::setUp();

        // util
        $this->objectManager = new ObjectManager();

        // color index
        $byteFactory = new ByteFactory($this->objectManager);
        $colorFactory = new ColorFactory($this->objectManager);
        $this->colorIndex = new ColorIndex($byteFactory, $colorFactory);

        $this->pointFactory = new PointFactory($this->objectManager);

        // pixel factory
        $channel = new Channel();
        $iteratorFactory = new PixelIteratoryFactory($this->objectManager, $channel);
        $this->pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->sizeFactory = new SizeFactory($this->objectManager);
    }

    /**
     * @dataProvider providerSerialIteratorJpeg
     *
     * @param string $path
     */
    public function testSerialIteratorJpeg(string $path)
    {
        $path = $this->getPath($path);
        $resource = new JpegResource($this->sizeFactory, $path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory
        );

        $image = new Image($resource, $iteratorFactory, $this->sizeFactory);

        // size
        $size = $image->getSize()->getHeight() * $image->getSize()->getWidth();
        $this->assertGreaterThan(0, $size);

        // path
        $actualPath = $resource->getPath();
        $this->assertEquals($path, $actualPath);

        // iteration
        $i = 0;
        /** @var \Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface $item */
        foreach ($image as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface', $item);

            $id = $item->getId();
            $this->assertNotEmpty($id);

            $color = $item->getColor()->toString();
            $this->assertNotEmpty($color);

            $i++;
        }
        $this->assertEquals($size, $i);

        // resource
        imagedestroy($image->getResource()->getResource());
    }

    public function providerSerialIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'parallel-lines-100x100px.jpeg'],
        ];
    }
}
