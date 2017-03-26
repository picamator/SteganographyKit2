<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\LsbImage\SecretText;

use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * SecretText is an information for hide or protection signature
 *
 * Class type
 * ----------
 * Non-sharable service.
 *
 * Responsibility
 * --------------
 * Iterate over ``Image`` with ``EndMark``
 *
 * @see \Picamator\SteganographyKit2\LsbText\SecretText\SecretText
 * @package LsbImage\SecretText
 */
class SecretText implements SecretTextInterface
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var int
     */
    private $countBit;

    /**
     * @param ImageInterface $image
     * @param ChannelInterface $channel
     */
    public function __construct(ImageInterface $image, ChannelInterface $channel)
    {
        $this->image = $image;
        $this->channel = $channel;

        $this->iterator = $image->getIterator();
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return $this->image->getResource();
    }

    /**
     * @inheritDoc
     */
    public function getCountBit(): int
    {
        if (is_null($this->countBit)) {
            $size = $this->image->getSize();
            $this->countBit = $size->getHeight() * $size->getWidth() *  $this->channel->count() * 8;
        }

        return $this->countBit;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        return $this->iterator->next();
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->iterator->valid() && $this->hasChildren();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * @inheritDoc
     */
    public function hasChildren()
    {
        return (is_object($this->current()) && is_a($this->current(), 'IteratorAggregate'));
    }

    /**
     * @inheritDoc
     */
    public function getChildren()
    {
        return $this->current()->getIterator();
    }
}
