<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\NullColor;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Create Pixel object
 *
 * @package Kernel\Pixel
 *
 * @codeCoverageIgnore
 */
final class PixelFactory implements PixelFactoryInterface
{
    /**
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @param IteratorFactoryInterface $iteratorFactory
     */
    public function __construct(IteratorFactoryInterface $iteratorFactory)
    {
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(PointInterface $point, ColorInterface $color = null) : PixelInterface
    {
        $color = $color ?? new NullColor();

        return new Pixel($point, $color, $this->iteratorFactory);
    }
}
