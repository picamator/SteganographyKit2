<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Builder;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Create Info palette object
 *
 * @package Kernel\File
 */
interface InfoPaletteFactoryInterface
{
    /**
     * Create
     *
     * @param SizeInterface $size
     *
     * @return InfoInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(SizeInterface $size) : InfoInterface;
}
