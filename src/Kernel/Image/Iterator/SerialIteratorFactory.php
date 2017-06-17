<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorInterface;

/**
 * Create Serial Iterator object
 *
 * Iterator factory makes possible to substitute iterator.
 * The ``Image`` depends on ``IteratorFactory`` and create iterator on first running ``Image->getIterator()``.
 *
 * @package Kernel\Image\Iterator
 *
 * @codeCoverageIgnore
 */
final class SerialIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : IteratorInterface
    {
        return new SerialIterator($image);
    }
}
