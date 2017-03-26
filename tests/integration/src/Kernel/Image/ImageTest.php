<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\InfoFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
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
        $nullByte = new NullByte();
        $colorFactory = new ColorFactory($this->objectManager, $nullByte);
        $this->colorIndex = new ColorIndex($byteFactory, $colorFactory);

        $this->pointFactory = new PointFactory($this->objectManager);

        // pixel factory
        $channel = new Channel(['red', 'green', 'blue']);
        $iteratorFactory = new PixelIteratoryFactory($this->objectManager, $channel);
        $this->pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->sizeFactory = new SizeFactory($this->objectManager);
    }

    /**
     * @dataProvider providerSerialBytewiseIteratorJpeg
     *
     * @param string $path
     */
    public function testSerialBytewiseIteratorJpeg(string $path)
    {
        $path = $this->getPath($path);
        $exportPath = $this->getPath('tmp');

        // resource
        $infoFactory = new InfoFactory($this->objectManager, $this->sizeFactory);
        $info = $infoFactory->create($path);

        $resource = new JpegResource($info->getSize(), $path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory
        );

        // export
        $writablePath = new WritablePath($exportPath);
        $nameGenerator = new SourceIdentical();
        $exportStrategy = new JpegFile($writablePath, $nameGenerator);

        $image = new Image($resource, $iteratorFactory, $exportStrategy);

        // size
        $size = $image->getSize()->getHeight() * $image->getSize()->getWidth();
        $this->assertGreaterThan(0, $size);

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

    public function providerSerialBytewiseIteratorJpeg()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }
}
