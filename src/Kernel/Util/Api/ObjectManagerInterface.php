<?php
namespace Picamator\SteganographyKit2\Kernel\Util\Api;

/**
 * Creates objects, the main usage inside factories.
 *
 * All objects are unshared, for shared objects please use DI service libraries
 */
interface ObjectManagerInterface
{
    /**
     * Create objects
     *
     * @param string $className
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $className, array $arguments = []);
}
