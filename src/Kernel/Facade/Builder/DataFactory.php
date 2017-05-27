<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Facade\Builder;

use Picamator\SteganographyKit2\Kernel\Facade\Api\Builder\DataFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\DataInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Data object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Create ``Data``
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
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\Facade
 *
 * @codeCoverageIgnore
 */
final class DataFactory implements DataFactoryInterface
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
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\Facade\Data\Data'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $data): DataInterface
    {
        return $this->objectManager->create($this->className, [$data]);
    }
}
