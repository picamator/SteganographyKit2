<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Iterator;

use Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Image\Api\ColorIndexInterface;
use Picamator\SteganographyKit2\Image\Api\Iterator\SerialIteratorInterface;
use Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Serial iterator
 *
 * Iterate pixel-by-pixel, row-by-row form to the left top corner to the bottom right
 */
class SerialIterator implements SerialIteratorInterface
{
    /**
     * @var ColorIndexInterface
     */
    private $colorIndex;

    /**
     * @var PointFactoryInterface
     */
    private $pointFactory;

    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

    /**
     * @var resource
     */
    private $resource;

    /**
     * Max value for X coordinate
     *
     * @var int
     */
    private $xMax;

    /**
     * Max value for Y coordinate
     *
     * @var int
     */
    private $yMax;

    /**
     * Current X coordinate
     *
     * @var int
     */
    private $x = 0;

    /**
     * Current Y coordinate
     *
     * @var int
     */
    private $y = 0;

    /**
     * Current index
     *
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
            ->setDefined('image')
            ->setRequired('image')
            ->setAllowedType('image', 'Picamator\SteganographyKit2\Image\Api\ImageInterface')

            ->setDefined('colorIndex')
            ->setRequired('colorIndex')
            ->setAllowedType('colorIndex', 'Picamator\SteganographyKit2\Image\Api\ColorIndexInterface')

            ->setDefined('pointFactory')
            ->setRequired('pointFactory')
            ->setAllowedType('pointFactory', 'Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface')

            ->setDefined('pixelFactory')
            ->setRequired('pixelFactory')
            ->setAllowedType('pixelFactory', 'Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface')

            ->resolve($options);

        $this->colorIndex = $optionsResolver->getValue('colorIndex');
        $this->pointFactory = $optionsResolver->getValue('pointFactory');
        $this->pixelFactory = $optionsResolver->getValue('pixelFactory');

        /** @var \Picamator\SteganographyKit2\Image\Api\ImageInterface $image */
        $image = $optionsResolver->getValue('image');

        $this->resource = $image->getResource();
        $this->xMax = $image->getSize()->getWidth();
        $this->yMax = $image->getSize()->getHeight();
    }

    /**
     * @inheritDoc
     *
     * @return PixelInterface
     */
    public function current()
    {
        $colorIndex = imagecolorat($this->resource, $this->x, $this->y);
        // strict types will rise exception for false color index
        $color = $this->colorIndex->getColor($colorIndex);

        $point = $this->pointFactory->create([
            'x' => $this->x,
            'y' => $this->y,
        ]);

        return $this->pixelFactory->create([
            'point' => $point,
            'color' => $color,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index ++;
        $this->x ++;
        if ($this->x >= $this->xMax) {
            $this->x = 0;
            $this->y ++;
        }
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        $xValid = $this->x < $this->xMax;
        $yValid = $this->y < $this->yMax;

        return  $xValid && $yValid;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->x = 0;
        $this->y = 0;
        $this->index = 0;
    }
}
