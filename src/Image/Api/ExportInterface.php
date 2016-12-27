<?php
namespace Picamator\SteganographyKit2\Image\Api;

interface ExportInterface
{
    /**
     * Gets status
     *
     * @return bool true for successful export, false otherwise
     */
    public function getStatus() : bool;

    /**
     * Gets data
     *
     * @return string
     */
    public function getData() : string;
}
