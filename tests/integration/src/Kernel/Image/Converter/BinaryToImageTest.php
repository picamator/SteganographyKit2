<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\NullColor;
use Picamator\SteganographyKit2\Kernel\Pixel\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\RepositoryFactory;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoPaletteFactory;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\File\Resource\ResourceFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToImage;
use Picamator\SteganographyKit2\Kernel\Image\Converter\ImageToBinary;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\ImageFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialNullIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIteratorFactory as PixelIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\PointFactory;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

class BinaryToImageTest extends BaseTest
{
    /**
     * @var BinaryToImage
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
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var ByteFactory
     */
    private $byteFactory;

    /**
     * @var ColorFactory
     */
    private $colorFactory;

    /**
     * @var InfoPaletteFactory
     */
    private $infoFactory;

    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * @var PixelFactory
     */
    private $pixelFactory;

    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var RepositoryFactory
     */
    private $repositoryFactory;

    /**
     * @var PointFactory
     */
    private $pointFactory;

    /**
     * @var SerialNullIteratorFactory
     */
    private $imageIteratorFactory;

    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

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

        // util
        $this->objectManager = new ObjectManager();

        $nullByte = new NullByte();

        $nullColor = new NullColor();

        $this->channel = new Channel($this->channelList);

        $this->byteFactory = new ByteFactory($this->objectManager);

        $this->colorFactory = new ColorFactory($this->objectManager, $nullByte);

        $this->infoFactory = new InfoPaletteFactory( $this->objectManager );

        $this->resourceFactory = new ResourceFactory($this->objectManager);

        // pixel factory
        $iteratorFactory = new PixelIteratorFactory($this->objectManager,  $this->channel);
        $this->pixelFactory = new PixelFactory($this->objectManager, $nullColor, $iteratorFactory);

        // repository factory
        $this->colorIndex = new ColorIndex($this->byteFactory, $this->colorFactory);

        $this->repositoryFactory = new RepositoryFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->colorFactory,
            $this->pixelFactory
        );

        // image iterator factory
        $this->pointFactory = new PointFactory($this->objectManager);

        $this->imageIteratorFactory = new SerialNullIteratorFactory(
            $this->objectManager,
            $this->pointFactory,
            $this->pixelFactory
        );

        $this->imageFactory = new ImageFactory(
            $this->objectManager,
            $this->resourceFactory,
            $this->repositoryFactory,
            $this->imageIteratorFactory
        );

        $this->sizeFactory = new SizeFactory($this->objectManager);

        $this->converter = new BinaryToImage(
            $this->channel,
            $this->byteFactory,
            $this->colorFactory,
            $this->infoFactory,
            $this->imageFactory
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
        $exportPath = $this->getPath('tmp');
        $name = pathinfo($path, PATHINFO_BASENAME);

        // convert
        $size = $this->sizeFactory->create($width, $height);
        $binaryText = $this->getBinaryFromImage($path);
        $image = $this->converter->convert($size, $binaryText);

        // export
        $writablePath = new WritablePath($exportPath);
        $nameGenerator = new PrefixTime('binary-to-image');

        $exportStrategy = new JpegFile($writablePath, $nameGenerator);
        $actualPath = $exportStrategy->export($image->getResource());

        $this->assertFileExists($actualPath);
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
     * @param string $path
     *
     * @return string
     */
    private function getBinaryFromImage(string $path) : string
    {
        $path = $this->getPath($path);

        $image = $this->imageHelper->getJpegImage($path);
        $converter = new ImageToBinary($this->channel);

        return $converter->convert($image);
    }
}
