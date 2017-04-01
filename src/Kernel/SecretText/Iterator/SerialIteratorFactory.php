<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText\Iterator;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator\IteratorInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Serial bitwise iterator object
 *
 * Iterator factory helps to build iterators for ``SecretText`` object.
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
 * @package Kernel\SecretText\Iterator
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
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $className
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\SecretText\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function create(string $binaryText) : IteratorInterface
    {
        return $this->objectManager->create($this->className, [$binaryText]);
    }
}
