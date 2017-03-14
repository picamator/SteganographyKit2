<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\StegoText;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;

/**
 * StegoText is a result of combining SecretText into CoverText
 */
class StegoText implements StegoTextInterface
{
    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @param ImageInterface $image
     */
    public function __construct(ImageInterface $image)
    {
       $this->iterator = $image->getIterator();
       $this->image = $image;
    }

    /**
     * @inheritDoc
     *
     * @return ByteInterface
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
    public function getImage(): ImageInterface
    {
        return $this->image;
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
