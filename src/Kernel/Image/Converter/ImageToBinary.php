<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Converter;

use Picamator\SteganographyKit2\Kernel\Image\Api\Converter\ImageToBinaryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;

/**
 * Convert image to binary string
 *
 * Class type
 * ----------
 * Sharable helper service. The class is a namespace over methods.
 *
 * Responsibility
 * --------------
 * Convert ``Image`` to binary string
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
final class ImageToBinary implements ImageToBinaryInterface
{
    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @param ChannelInterface $channel
     */
    public function __construct(ChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @inheritDoc
     */
    public function convert(ImageInterface $image) : string
    {
        $binaryText = '';
        $channelIterator = new \ArrayIterator($this->channel->getMethodList());

        /** @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface $item */
        foreach($image as $item) {
            foreach ($channelIterator as $channelItem) {
                /** @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface $byteItem */
                $byteItem = $item->getColor()->$channelItem();
                $binaryText .= $byteItem->getBinary();
            }

            $channelIterator->rewind();
        }

       return $binaryText;
    }
}
