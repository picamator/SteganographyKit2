<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Iterator;

use Picamator\SteganographyKit2\Entity\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use RecursiveIterator;

/**
 * Serial iterator
 *
 * Iterate color channel, red-green-blue
 */
class SerialIterator implements SerialIteratorInterface
{
    /**
     * @var ColorInterface
     */
    private $color;

    /**
     * @var array
     */
    private $channelList = ['red', 'green', 'blue'];

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @param PixelInterface $pixel
     */
    public function __construct(PixelInterface $pixel)
    {
        // some algorithm might need pixel not only a color for iteration
        $this->color = $pixel->getColor();
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
        return $this->channelList[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->index <= 2;
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
     */
    public function getChildren()
    {
        return;
    }
}
