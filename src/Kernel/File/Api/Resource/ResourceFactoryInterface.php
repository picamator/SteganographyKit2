<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Resource;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;

/**
 * Create resource object
 *
 * @package Kernel\File\Resource
 */
interface ResourceFactoryInterface
{
    /**
     * Create
     *
     * @param InfoInterface $info
     *
     * @return ResourceInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(InfoInterface $info) : ResourceInterface;
}
