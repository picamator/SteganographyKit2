<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\File\Builder\InfoPaletteFactory;
use Picamator\SteganographyKit2\Kernel\Image\Api\Converter\BinaryToImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;

/**
 * Convert binary string to image
 *
 * Class type
 * ----------
 * Sharable helper service. The class is a namespace over methods.
 *
 * Responsibility
 * --------------
 * Convert binary string to ``Image``
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Image\Converter
 */
final class BinaryToImage implements BinaryToImageInterface
{
    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @var ImageFactoryInterface
     */
    private $imageFactory;

    /**
     * @param ChannelInterface $channel
     * @param ImageFactoryInterface $imageFactory
     */
    public function __construct(
        ChannelInterface $channel,
        ImageFactoryInterface $imageFactory
    ) {
        $this->channel = $channel;
        $this->imageFactory = $imageFactory;
    }

    /**
     * @inheritDoc
     */
    public function convert(SizeInterface $size, string $binaryText) : ImageInterface
    {
        $xMax = $size->getWidth();
        $yMax = $size->getHeight();

        $binaryLength = strlen($binaryText);
        $resourceCount = $xMax * $yMax * $this->channel->count() * 8;

        if ($resourceCount !== $binaryLength) {
            throw new InvalidArgumentException(
                sprintf('Invalid length correlation. Resource length "%s" should be the same as binary text "%s".', $resourceCount, $binaryLength)
            );
        }

        $info = $this->createInfo($size);
        $image = $this->imageFactory->createPaletteImage($info);

        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $iterator->attachIterator($this->getBinaryTextGenerator($binaryText), 'color');
        $iterator->attachIterator($image->getIterator(), 'pixel');

        $repository = $image->getRepository();
        foreach ($iterator as $item) {
            $item['pixel']->setColor($item['color']);
            $repository->insert($item['pixel']);
        }

        return $image;
    }

    /**
     * Gets binary text generator
     *
     * @param string $binaryText
     *
     * @return ByteInterface
     */
    private function getBinaryTextGenerator(string $binaryText)
    {
        $iterator = new \ArrayIterator($this->channel->getChannelList());
        $iterator = new \InfiniteIterator($iterator);

        $i = 0;
        $binaryLength = strlen($binaryText);
        while ($i < $binaryLength) {

            $byteBinary = substr($binaryText, $i, 8);
            $container[$iterator->current()] = $this->createByte($byteBinary);

            if (count($container) === $this->channel->count()) {
                $color = $this->createColor($container);
                // reset
                $container = [];

                yield $color;
            };

            $iterator->next();
            $i += 8;
        }
    }

    /**
     * @param string $byteBinary
     *
     * @return ByteInterface
     */
    private function createByte(string $byteBinary)
    {
        return ByteFactory::create($byteBinary);
    }

    /**
     * @param array $data
     *
     * @return \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface
     */
    private function createColor(array $data)
    {
        return ColorFactory::create($data);
    }

    /**
     * @param SizeInterface $size
     *
     * @return \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface
     */
    private function createInfo(SizeInterface $size)
    {
        return InfoPaletteFactory::create($size);
    }
}
