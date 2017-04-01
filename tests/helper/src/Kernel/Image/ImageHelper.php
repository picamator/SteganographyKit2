<?php
namespace Picamator\SteganographyKit2\Tests\Helper\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\File\Resource\ResourceFactory;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\ImageFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialNullIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\NullColor;
use Picamator\SteganographyKit2\Kernel\Pixel\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIteratorFactory as PixelSerialIteratorFactory;
use Picamator\SteganographyKit2\Kernel\File\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\RepositoryFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\PointFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;

/**
 * Help to get image object
 */
class ImageHelper
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
     * @var Channel
     */
    private $channel;

    /**
     * @var PixelFactory
     */
    private $pixelFactory;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    /**
     * @var SerialIteratorFactory
     */
    private $imageIteratorFactory;

    /**
     * @var RepositoryFactory
     */
    private $repositoryFactory;

    /**
     * @param string $imageIterator
     * @param string $pixelIterator
     * @param array $channelList
     */
    public function __construct(
        string $imageIterator = 'Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIterator',
        string $pixelIterator = 'Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIterator',
        array $channelList = ['red', 'green', 'blue']
    ) {
        // util
        $this->objectManager = new ObjectManager();

        // color
        $nullColor = new NullColor();

        // color index
        $byteFactory = new ByteFactory($this->objectManager);
        $nullByte = new NullByte();
        $colorFactory = new ColorFactory($this->objectManager, $nullByte);
        $this->colorIndex = new ColorIndex($byteFactory, $colorFactory);

        $this->pointFactory = new PointFactory($this->objectManager);

        // pixel factory
        $this->channel = new Channel($channelList);
        $iteratorFactory = new PixelSerialIteratorFactory($this->objectManager, $this->channel, $pixelIterator);
        $this->pixelFactory = new PixelFactory($this->objectManager, $nullColor, $iteratorFactory);

        $this->sizeFactory = new SizeFactory($this->objectManager);

        // image iterator
        $this->imageIteratorFactory =  new SerialIteratorFactory($this->objectManager, $this->pointFactory, $imageIterator);

        // repository
        $this->repositoryFactory = new RepositoryFactory(
            $this->objectManager,
            $this->colorIndex,
            $colorFactory,
            $this->pixelFactory
        );
    }

    /**
     * Gets jpeg image
     *
     * @param string $path
     *
     * @return ImageInterface
     */
    public function getJpegImage(string $path) : ImageInterface
    {
        // resource
        $infoFactory = new InfoFactory($this->objectManager, $this->sizeFactory);
        $info = $infoFactory->create($path);

        $resource = new JpegResource($info, $path);

        $repository = $this->repositoryFactory->create($resource);

        return new Image($repository, $this->imageIteratorFactory);
    }

    /**
     * Gets palette factory
     *
     * @return ImageFactoryInterface
     */
    public function getPaletteImageFactory() : ImageFactoryInterface
    {
        $resourceFactory = new ResourceFactory($this->objectManager);

        $imageIteratorFactory = new SerialNullIteratorFactory(
            $this->objectManager,
            $this->pointFactory,
            $this->pixelFactory
        );

        $imageFactory = new ImageFactory(
            $this->objectManager,
            $resourceFactory,
            $this->repositoryFactory,
            $imageIteratorFactory
        );

        return $imageFactory;
    }

    /**
     * Gets channel
     *
     * @return ChannelInterface
     */
    public function getChannel() : ChannelInterface
    {
        return $this->channel;
    }
}
