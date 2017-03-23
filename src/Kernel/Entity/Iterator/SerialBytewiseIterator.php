<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Serial bytewise iterator
 *
 * Iterate color channel, red-green-blue.
 * Channels validation provided by factory for performance reason.
 * The channels order in array important for encode as well as for decode.
 *
 * Class type
 * ----------
 * Non-sharable entity. Each ``Pixel`` owns it's own iterator.
 *
 * Responsibility
 * --------------
 * Iterate over ``Color`` channels
 *
 * State
 * -----
 * * Iteration state: current, key, etc.
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Cannot be injected in any class. Iterator owns only by ``Pixel``.
 *
 * @package Kernel\Entity\Iterator
 */
class SerialBytewiseIterator implements SerialIteratorInterface
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
    private $index = 0;

    /**
     * @param PixelInterface $pixel
     * @param ChannelInterface $channel
     */
    public function __construct(PixelInterface $pixel, ChannelInterface $channel)
    {
        // some algorithm might need pixel not only a color for iteration
        $this->color = $pixel->getColor();
        $this->channel = $channel;
    }

    /**
     * @inheritDoc
     *
     * @return ByteInterface
     */
    public function current()
    {
        $method = $this->channel->getMethodChannels()[$this->index];

        return $this->color->$method();
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
        return $this->channel->getChannels()[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->index < $this->channel->count();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
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
