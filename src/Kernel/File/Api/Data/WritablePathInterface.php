<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api\Data;

/**
 * Writable path value object
 */
interface WritablePathInterface
{
    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string;
}
