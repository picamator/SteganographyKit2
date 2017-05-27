<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Iterator;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Iterator\IteratorInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface;
use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Serial Iterator object
 *
 * Iterator factory helps to build iterators for ``Pixel`` object.
 * The ``Pixel`` object owns it's iterator but to make possible change iteration process the ``IteratorFactory`` is used.
 * In other words ``Pixel`` depends on ``IteratorFactory``, creates iterator instance in first call of ``Pixel->getIterator()``.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Iterator``.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Pixel\Iterator
 *
 * @codeCoverageIgnore
 */
final class SerialIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ChannelInterface
     */
    private $channel;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ChannelInterface $channel
     * @param string $className
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ChannelInterface $channel,
        string $className = 'Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->channel = $channel;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function create(PixelInterface $pixel) : IteratorInterface
    {
        return $this->objectManager->create($this->className, [$pixel, $this->channel]);
    }
}
