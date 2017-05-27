<?php
namespace Picamator\SteganographyKit2\Kernel\Facade\Api\Builder;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\DataInterface;

/**
 * Create Data object
 *
 * @package Kernel\Facade
 */
interface DataFactoryInterface
{
    /**
     * Create
     *
     * @param string $data
     *
     * @return DataInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $data): DataInterface;
}
