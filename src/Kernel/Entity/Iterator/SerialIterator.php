<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Entity\Iterator;

use Picamator\SteganographyKit2\Kernel\Entity\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;

/**
 * Serial iterator
 *
 * Iterate color channel, red-green-blue-alpha
 * Channels validation provided by factory for performance reason
 * The channels order in array important for encode as well as for decode
 */
class SerialIterator implements SerialIteratorInterface
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
        $method = 'get' . ucwords($this->key());

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
