<?php
namespace Picamator\SteganographyKit2\Kernel\Facade\Api\Data;

/**
 * Data value object
 *
 * @package Kernel\Facade
 */
interface DataInterface
{
    /**
     * Gets data
     *
     * @return string
     */
    public function getData() : string;
}
