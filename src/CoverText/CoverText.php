<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\CoverText;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface;

/**
 * CoverText is an image witch serves as a container for SecretText
 *
 * When CoverText holds SecretText it becomes StegoText in fashion to keep SecretText exposed
 */
class CoverText implements CoverTextInterface
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
