<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;

/**
 * StegoText is a result of combining SecretText into CoverText
 *
 * Class type
 * ----------
 * Non-sharable service.
 *
 * Responsibility
 * --------------
 * Implement ``RecursiveIterator`` to make possible iterate over Image->Pixel->Channels
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
 * Only as a method argument, because ``StegoText`` depends from user data - image ``path``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\StegoText
 */
final class StegoText implements StegoTextInterface
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
