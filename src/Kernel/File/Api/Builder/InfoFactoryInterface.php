<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Builder;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;

/**
 * Create Info object
 *
 * @package Kernel\File
 */
interface InfoFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return InfoInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $path) : InfoInterface;
}
