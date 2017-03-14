<?php
namespace Picamator\SteganographyKit2\Tests\Integration\StegoText;

use Picamator\SteganographyKit2\Entity\PixelFactory;
use Picamator\SteganographyKit2\Image\ColorFactory;
use Picamator\SteganographyKit2\Image\ColorIndex;
use Picamator\SteganographyKit2\Image\Image;
use Picamator\SteganographyKit2\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Image\SizeFactory;
use Picamator\SteganographyKit2\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Primitive\PointFactory;
use Picamator\SteganographyKit2\StegoText\StegoText;
use Picamator\SteganographyKit2\Tests\Integration\BaseTest;
use Picamator\SteganographyKit2\Util\ObjectManager;

class StegoTextTest extends BaseTest
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
        $iteratorFactory = new PixelIteratoryFactory($this->objectManager);
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
        $resource = new JpegResource($path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory
        );

        $image = new Image($resource, $iteratorFactory, $this->sizeFactory);
        $size = $image->getSize()->getHeight() * $image->getSize()->getWidth();

        $stegoText = new StegoText($image);
        $iterator = new \RecursiveIteratorIterator($stegoText);

        // iteration
        $i = 0;
        /** @var \Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface $item */
        foreach ($iterator as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface', $item);

            $id = $item->getInt();
            $this->assertInternalType('int', $id);
            $this->assertLessThanOrEqual(255, $id);

            $i++;
        }
        $this->assertEquals($size * 3, $i);

        // resource
        imagedestroy($image->getResource());
    }

    public function providerSerialIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'parallel-lines-100x100px.jpeg'],
        ];
    }
}
