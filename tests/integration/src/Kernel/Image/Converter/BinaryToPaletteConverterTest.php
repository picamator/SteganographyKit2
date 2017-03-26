<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Entity\PixelRepositoryFactory;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToPaletteConverter;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegString;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\Resource\PaletteResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\LsbImage\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

class BinaryToPaletteConverterTest extends BaseTest
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
     * @var PixelRepositoryFactory
     */
    private $pixelRepositoryFactory;

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
        $iteratorFactory = new PixelIteratoryFactory($this->objectManager,  $this->channel);
        $this->pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->sizeFactory = new SizeFactory($this->objectManager);

        $this->pixelRepositoryFactory = new PixelRepositoryFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->colorFactory
        );

        // image iterator factory
        $this->imageIteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $this->pixelFactory
        );
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
        $binaryText = $this->getBinaryFromImage($width, $height, $path);

        $exportPath = $this->getPath('tmp');
        $name = pathinfo($path, PATHINFO_BASENAME);

        // resource
        $resource = new PaletteResource($this->sizeFactory->create($width, $height), $name);

        // image
        $writablePath = new WritablePath($exportPath);
        $nameGenerator = new SourceIdentical();
        $exportStrategy = new JpegFile($writablePath, $nameGenerator);

        $image = new Image($resource, $this->imageIteratorFactory, $exportStrategy);

        // convert
        $converter = new BinaryToPaletteConverter(
            $this->channel,
            $this->byteFactory,
            $this->colorFactory,
            $this->pixelRepositoryFactory
        );

        $converter->convert($image, $binaryText);

        // export
        $actualPath = $image->export();
        $this->assertFileExists($actualPath);

        // resource
        imagedestroy($image->getResource()->getResource());
    }

    public function providerConvertJpeg()
    {
        return [
            [25, 1, 'secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg'],
            [1, 25, 'secret' . DIRECTORY_SEPARATOR . 'black-white-vertical-stripe-1x25px.jpg'],
        ];
    }

    /**
     * Gets binary
     *
     * @param int $width
     * @param int $height
     * @param string $path
     *
     * @return string
     */
    private function getBinaryFromImage(int $width, int $height, string $path) : string
    {
        $path = $this->getPath($path);

        // pixel factory
        $iteratorFactory = new PixelIteratoryFactory(
            $this->objectManager,
            $this->channel,
            'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator'
        );
        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        // image
        $jpegResource = new JpegResource($this->sizeFactory->create($width, $height), $path);

        $iteratorFactory = new IteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $exportStrategy = new JpegString();

        $image = new Image($jpegResource, $iteratorFactory, $exportStrategy);

        $secretText = new SecretText($image, $this->channel);
        $iterator = new \RecursiveIteratorIterator($secretText);

        $binaryText = '';
        foreach($iterator as $item) {
            $binaryText .= $item;
        }

        return $binaryText;
    }
}
