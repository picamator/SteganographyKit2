<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelRepositoryFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ConverterInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Convert binary string to Palette resource
 *
 * Class type
 * ----------
 * Sharable helper service. The class is a namespace over methods.
 *
 * Responsibility
 * --------------
 * Comvert binary string to ``Image`` with ``PaletteResource``
 *
 * State
 * -----
 * * Channel iterator
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
class BinaryToPaletteConverter implements ConverterInterface
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
     * @var PixelRepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * @param ChannelInterface $channel
     * @param ByteFactoryInterface $byteFactory
     * @param ColorFactoryInterface $colorFactory
     * @param PixelRepositoryFactoryInterface $repositoryFactory
     */
    public function __construct(
        ChannelInterface $channel,
        ByteFactoryInterface $byteFactory,
        ColorFactoryInterface $colorFactory,
        PixelRepositoryFactoryInterface $repositoryFactory
    ) {
        $this->channel = $channel;
        $this->byteFactory = $byteFactory;
        $this->colorFactory = $colorFactory;
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * @inheritDoc
     */
    public function convert(ImageInterface $image, string $binaryText)
    {
        $xMax = $image->getResource()->getSize()->getWidth();
        $yMax = $image->getResource()->getSize()->getHeight();

        $binaryLength = strlen($binaryText);
        $resourceBitCount = $xMax * $yMax * $this->channel->count() * 8;

        if ($resourceBitCount !== $binaryLength) {
            throw new InvalidArgumentException(
                sprintf('Invalid length correlation. Resource length "%s" should be the same as binary text "%s".', $resourceBitCount, $binaryLength)
            );
        }

        $repository = $this->repositoryFactory->create($image->getResource());

        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $iterator->attachIterator($this->getBinaryTextGenerator($binaryText), 'color');
        $iterator->attachIterator($image->getIterator(), 'pixel');

        foreach ($iterator as $item) {
            $item['pixel']->setColor($item['color']);
            $repository->insert($item['pixel']);
        }
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
        $iterator = new \ArrayIterator($this->channel->getChannels());
        $binaryLength = strlen($binaryText);

        $i = 0;
        $colorContainer = [];
        while ($i < $binaryLength) {

            if (!$iterator->valid()) {
                $color = $this->colorFactory->create($colorContainer);

                // reset
                $colorContainer = [];
                $iterator->rewind();

                yield $color;
            };

            $byteBinary = substr($binaryText, $i, 8);
            $colorContainer[$iterator->current()] = $this->byteFactory->create($byteBinary);

            $iterator->next();
            $i += 8;
        }

        // last color container
        if(!empty($colorContainer)) {
            yield $this->colorFactory->create($colorContainer);
        }
    }
}
