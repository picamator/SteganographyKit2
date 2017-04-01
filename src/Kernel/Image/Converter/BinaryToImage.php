<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\File\Api\Builder\InfoPaletteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Converter\BinaryToImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

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
     * @var ByteFactoryInterface
     */
    private $byteFactory;

    /**
     * @var ColorFactoryInterface
     */
    private $colorFactory;

    /**
     * @var InfoPaletteFactoryInterface
     */
    private $infoFactory;

    /**
     * @var ImageFactoryInterface
     */
    private $imageFactory;

    /**
     * @param ChannelInterface $channel
     * @param ByteFactoryInterface $byteFactory
     * @param ColorFactoryInterface $colorFactory
     * @param InfoPaletteFactoryInterface $infoFactory
     * @param ImageFactoryInterface $imageFactory
     */
    public function __construct(
        ChannelInterface $channel,
        ByteFactoryInterface $byteFactory,
        ColorFactoryInterface $colorFactory,
        InfoPaletteFactoryInterface $infoFactory,
        ImageFactoryInterface $imageFactory
    ) {
        $this->channel = $channel;
        $this->byteFactory = $byteFactory;
        $this->colorFactory = $colorFactory;
        $this->infoFactory = $infoFactory;
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

        $info = $this->infoFactory->create($size);
        $image = $this->imageFactory->create($info);

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
            $container[$iterator->current()] = $this->byteFactory->create($byteBinary);

            if (count($container) === $this->channel->count()) {
                $color = $this->colorFactory->create($container);
                // reset
                $container = [];

                yield $color;
            };

            $iterator->next();
            $i += 8;
        }
    }
}
