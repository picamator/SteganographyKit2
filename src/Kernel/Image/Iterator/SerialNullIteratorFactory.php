<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorInterface;

/**
 * Create Serial null iterator object
 *
 * Iterator factory makes possible to substitute iterator.
 * The ``Image`` depends on ``IteratorFactory`` and create iterator on first running ``Image->getIterator()``.
 *
 * @package Kernel\Image\Iterator
 *
 * @codeCoverageIgnore
 */
final class SerialNullIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var PixelFactoryInterface
     */
    private $pixelFactory;

    /**
     * @param PixelFactoryInterface $pixelFactory
     */
    public function __construct(PixelFactoryInterface $pixelFactory)
    {
        $this->pixelFactory = $pixelFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : IteratorInterface
    {
        return new SerialNullIterator($image->getInfo()->getSize(), $this->pixelFactory);
    }
}
