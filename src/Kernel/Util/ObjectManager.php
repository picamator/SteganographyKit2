<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Util;

use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;

/**
 * Creates objects, the main usage inside factories.
 *
 * All objects are unshared, for shared objects please use DI service libraries.
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
class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var array
     */
    private $reflectionContainer;

    /**
     * {@inheritdoc}
     */
    public function create(string $className, array $arguments = [])
    {
        if (empty($arguments)) {
            return new $className();
        }

        // construction does not available
        if (method_exists($className, '__construct') === false) {
            throw new RuntimeException(sprintf('Class "%s" does not have __construct', $className));
        }

        return $this->getReflection($className)
            ->newInstanceArgs($arguments);
    }

    /**
     * Retrieve reflection.
     *
     * @param string $className
     *
     * @return \ReflectionClass
     */
    private function getReflection($className)
    {
        if (empty($this->reflectionContainer[$className])) {
            $this->reflectionContainer[$className] = new \ReflectionClass($className);
        }

        return $this->reflectionContainer[$className];
    }
}
