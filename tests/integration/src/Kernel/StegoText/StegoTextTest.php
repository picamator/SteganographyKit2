<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\StegoText;

use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\Kernel\StegoText\StegoText;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

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

        $this->sizeFactory = new SizeFactory($this->objectManager);
    }

    /**
     * @dataProvider providerSerialBytewiseIteratorJpeg
     *
     * @param string $path
     */
    public function testSerialBytewiseIteratorJpeg(string $path)
    {
        // pixel factory
        $channel = new Channel();
        $iteratorFactory = new PixelIteratorFactory($this->objectManager, $channel);
        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        // image
        $path = $this->getPath($path);
        $resource = new JpegResource($this->sizeFactory, $path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $image = new Image($resource, $iteratorFactory, $this->sizeFactory);
        $size = $image->getSize()->getHeight() * $image->getSize()->getWidth();

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
        $this->assertEquals($size * $channel->count(), $i);

        // resource
        imagedestroy($image->getResource()->getResource());
    }

    /**
     * @dataProvider providerSerialBitwiseIteratorJpeg
     *
     * @param string $path
     */
    public function testSerialBitwiseIteratorJpeg(string $path)
    {
        $expected = ['0', '1'];

        // pixel factory
        $channel = new Channel();
        $iteratorFactory = new PixelIteratorFactory(
            $this->objectManager,
            $channel,
            'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator'
        );
        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        // image
        $path = $this->getPath($path);
        $resource = new JpegResource($this->sizeFactory, $path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $image = new Image($resource, $iteratorFactory, $this->sizeFactory);
        $size = $image->getSize()->getHeight() * $image->getSize()->getWidth();

        $stegoText = new StegoText($image);
        $iterator = new \RecursiveIteratorIterator($stegoText);

        // iteration
        $i = 0;
        foreach ($iterator as $key => $value) {
            $this->assertContains($value, $expected);
            $i++;
        }
        $this->assertEquals($size * $channel->count() * 8, $i);

        // resource
        imagedestroy($image->getResource()->getResource());
    }

    public function providerSerialBitwiseIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'parallel-lines-100x100px.jpeg'],
        ];
    }

    public function providerSerialBytewiseIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'parallel-lines-100x100px.jpeg'],
        ];
    }
}
