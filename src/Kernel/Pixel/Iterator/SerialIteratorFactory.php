<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Iterator;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;

/**
 * Create Serial Iterator object
 *
 * Iterator factory helps to build iterators for ``Pixel`` object.
 * The ``Pixel`` object owns it's iterator but to make possible change iteration process the ``IteratorFactory`` is used.
 * In other words ``Pixel`` depends on ``IteratorFactory``, creates iterator instance in first call of ``Pixel->getIterator()``.
 *
 * @package Kernel\Pixel\Iterator
 *
 * @codeCoverageIgnore
 */
final class SerialIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @param ChannelInterface $channel
     *
     * @throws InvalidArgumentException
     */
    public function __construct(ChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function create(PixelInterface $pixel) : IteratorInterface
    {
        return new SerialIterator($pixel, $this->channel);
    }
}
