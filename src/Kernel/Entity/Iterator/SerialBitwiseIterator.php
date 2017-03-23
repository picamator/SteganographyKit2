<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Serial bitwise iterator
 *
 * Iterate color channel red-green-blue bit by bit.
 * Channels validation provided by factory for performance reason.
 * The channels order inside array is important for encode as well as for decode.
 *
 * *Attention* Channel does not support alpha therefore it might be lost in encode-decode process
 *
 * @package Kernel\Entity\Iterator
 * @see \Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBytewiseIterator
 */
class SerialBitwiseIterator implements SerialIteratorInterface
{
    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @var int
     */
    private $maxIndex;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var string
     */
    private $currentChannel;

    /**
     * @var array
     */
    private $currentContainer;

    /**
     * @param PixelInterface $pixel
     * @param ChannelInterface $channel
     */
    public function __construct(PixelInterface $pixel, ChannelInterface $channel)
    {
        // some algorithm might need pixel not only a color for iteration
        $this->color = $pixel->getColor();
        $this->channel = $channel;
        $this->maxIndex = $this->channel->count() * 8;
    }

    /**
     * @inheritDoc
     *
     * @return string "0" or "1"
     */
    public function current()
    {
        if (empty($this->currentContainer)) {
            $channelIndex = $this->index / 8;
            $this->currentChannel = $this->channel->getChannels()[$channelIndex];

            $method = $this->channel->getMethodChannels()[$channelIndex];

            /** @var ByteInterface $byte */
            $byte = $this->color->$method();

            $this->currentContainer = str_split($byte->getBinary());
        }

        return array_shift($this->currentContainer);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index ++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->currentChannel . '-' . $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->index < $this->maxIndex;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
        $this->currentContainer = null;
        $this->currentChannel = current($this->channel->getChannels());
    }

    /**
     * @inheritDoc
     */
    public function hasChildren()
    {
        return false;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getChildren()
    {
        return;
    }
}
