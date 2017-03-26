<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegString;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\LsbImage\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

class SecretTextTest extends BaseTest
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ByteFactory
     */
    private $byteFactory;

    /**
     * @var ColorFactory
     */
    private $colorFactory;

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

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var IteratorFactory
     */
    private $imageIteratorFactory;

    protected function setUp()
    {
        parent::setUp();

        // util
        $this->objectManager = new ObjectManager();

        // color index
        $this->byteFactory = new ByteFactory($this->objectManager);
        $nullByte = new NullByte();
        $this->colorFactory = new ColorFactory($this->objectManager, $nullByte);
        $this->colorIndex = new ColorIndex($this->byteFactory, $this->colorFactory);

        $this->pointFactory = new PointFactory($this->objectManager);

        // pixel factory
        $this->channel = new Channel(['red', 'green', 'blue']);
        $iteratorFactory = new PixelIteratoryFactory(
            $this->objectManager,
            $this->channel,
            'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator'
        );
        $this->pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->sizeFactory = new SizeFactory($this->objectManager);

        // image iterator factory
        $this->imageIteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory
        );
    }

    /**
     * @dataProvider providerIterator
     *
     * @param int $width
     * @param int $height
     * @param string $path
     */
    public function testIterator(int $width, int $height, string $path)
    {
        $expected = ['0', '1'];
        $path = $this->getPath($path);

        // image
        $jpegResource = new JpegResource($this->sizeFactory->create($width, $height), $path);

        $exportStrategy = new JpegString();

        $image = new Image($jpegResource, $this->imageIteratorFactory, $exportStrategy);

        $secretText = new SecretText($image, $this->channel);
        $iterator = new \RecursiveIteratorIterator($secretText);

        $i = 0;
        foreach($iterator as $item) {
            $this->assertContains($item, $expected);
            $this->assertEquals(1, strlen($item));

            $i++;
        }

        $this->assertEquals($i, $secretText->getCountBit());
    }

    public function providerIterator()
    {
        return [
            [25, 1, 'secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            [1, 25, 'secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }
}
