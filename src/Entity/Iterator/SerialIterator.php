<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Iterator;

use Picamator\SteganographyKit2\Entity\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

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
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
            ->setDefined('pixel')
            ->setRequired('pixel')
            ->setAllowedType('pixel', 'Picamator\SteganographyKit2\Entity\Api\PixelInterface')

            ->resolve($options);

        // some algorithm might need pixel not only a color for iteration
        $this->color = $optionsResolver->getValue('pixel')->getColor();
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
}
