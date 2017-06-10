<?php
namespace Picamator\SteganographyKit2\Kernel\Facade\Api;

use Picamator\SteganographyKit2\Kernel\Facade\Api\Data\DataInterface;

/**
 * Resolve abstract data
 *
 * @package Kernel\Facade
 */
interface DataResolverInterface
{
    /**
     * Resolve
     *
     * @param mixed $data
     *
     * @return DataInterface
     */
    public function resolve($data) : DataInterface;

    /**
     * Sets resolver
     *
     * @param DataResolverInterface $resolver
     *
     * @return DataResolverInterface
     */
    public function setResolver(DataResolverInterface $resolver) : DataResolverInterface;
}
