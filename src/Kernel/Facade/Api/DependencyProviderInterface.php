<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

/**
 * Dependency provider
 *
 * @package Kernel\Facade
 */
interface DependencyProviderInterface
{
    /**
     * Gets provided dependency
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function getProvidedDependency(string $name);
}
