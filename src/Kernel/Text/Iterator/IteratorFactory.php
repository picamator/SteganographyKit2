<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Iterator;

use Picamator\SteganographyKit2\Kernel\Text\Api\AsciiFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
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
 * * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Text\Iterator
 *
 * @codeCoverageIgnore
 */
class IteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var AsciiFactoryInterface
     */
    private $asciiFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param AsciiFactoryInterface $asciiFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        AsciiFactoryInterface $asciiFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Text\Iterator\SerialBitwiseIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->asciiFactory = $asciiFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(TextInterface $text) : \Iterator
    {
        return $this->objectManager->create($this->className, [$text, $this->asciiFactory ]);
    }
}
