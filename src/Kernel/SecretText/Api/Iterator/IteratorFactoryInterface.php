<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api\Iterator;

/**
 * Create Iterator object
 *
 * @package Kernel\SecretText\Iterator
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param string $binaryText
     *
     * @return IteratorInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $binaryText) : IteratorInterface;
}
