<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText\Iterator;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorInterface;

/**
 * Create Serial bitwise iterator object
 *
 * Iterator factory helps to build iterators for ``SecretText`` object.
 *
 * @package Kernel\SecretText\Iterator
 *
 * @codeCoverageIgnore
 */
final class SerialIteratorFactory implements IteratorFactoryInterface
{
    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function create(string $binaryText) : IteratorInterface
    {
        return new SerialIterator($binaryText);
    }
}
