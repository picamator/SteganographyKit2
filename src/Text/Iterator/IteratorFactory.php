<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Text\Iterator;

use Picamator\SteganographyKit2\Text\Api\AsciiFactoryInterface;
use Picamator\SteganographyKit2\Text\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Text\Api\TextInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Iterator object
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
        string $className = 'Picamator\SteganographyKit2\Text\Iterator\SerialIterator'
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
