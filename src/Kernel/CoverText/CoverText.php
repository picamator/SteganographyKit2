<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\CoverText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;

/**
 * CoverText is an image container for SecretText, when CoverText holds SecretText it becomes StegoText
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
 * Only as a method argument, because ``CoverText`` depends from user data - image ``path``.
 * That make possible initiate once basic objects and reuse them inside loop over container with ``path``.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\CoverText
 */
final class CoverText implements CoverTextInterface
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
