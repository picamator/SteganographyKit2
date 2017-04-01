<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Builder\TextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\Data\TextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Text object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Apply filters
 * * Create ``Text``
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
 * Check list
 * ----------
 * * Single responsibility ``-``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\Text
 */
final class TextFactory implements TextFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var FilterManagerInterface
     */
    private $filterManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param FilterManagerInterface $filterManager
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        FilterManagerInterface $filterManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\Text\Data\Text'
    ) {
        $this->objectManager = $objectManager;
        $this->filterManager = $filterManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $text) : TextInterface
    {
        $text = $this->filterManager->apply($text);

        return $this->objectManager->create($this->className, [$text]);
    }
}
