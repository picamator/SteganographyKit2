<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\WritablePathFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Writable path value object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Validate ``$path``
 * * Create sub directory if needed
 * * Create ``WritablePath``
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as constructor argument.
 *
 * Check list
 * ----------
 * * Single responsibility ``-``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
class WritablePathFactory implements WritablePathFactoryInterface
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
        $className = 'Picamator\SteganographyKit2\Kernel\File\Data\WritablePath'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $path) : WritablePathInterface
    {
        if(!file_exists($path) && !mkdir($path, 0755, true)) {
            throw new InvalidArgumentException(
                sprintf('Impossible create sub-folders structure for destination "%s"', $path)
            );
        }

        if(!is_writable($path)) {
            throw new InvalidArgumentException(
                sprintf('Destination does not have writable permission "%s"', $path)
            );
        }

        return $this->objectManager->create($this->className, [$path]);
    }
}
