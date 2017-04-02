<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Util;

use Picamator\ObjectManager\Api\ObjectManagerInterface as VendorObjectManagerInterface;
use Picamator\ObjectManager\Exception\RuntimeException as VendorRuntimeException;
use Picamator\ObjectManager\ObjectManagerSingleton;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;

/**
 * Creates objects, the main usage inside factories.
 *
 * All objects are unshared, for shared objects please use DI service libraries.
 * It's a delegate Picamator\ObjectManager class with transforming vendors exception to own one.
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create objects.
 *
 * State
 * -----
 * * Class reflections
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Util
 */
final class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var VendorObjectManagerInterface
     */
    private $objectManager;

    public function __construct()
    {
        $this->objectManager = ObjectManagerSingleton::getInstance();
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $className, array $arguments = [])
    {
        try {
            return $this->objectManager->create($className, $arguments);
        } catch(VendorRuntimeException $e) {
            throw new RuntimeException(
                sprintf('Cannot instantiate "%s" with arguments ["%s"]', $className, implode(', ', $arguments)), 0, $e
            );
        }
    }
}
