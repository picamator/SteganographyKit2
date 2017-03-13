<?php
namespace Picamator\SteganographyKit2\Image\Api;

use Picamator\SteganographyKit2\Exception\RuntimeException;

/**
 * Export Image
 */
interface ExportInterface
{
    /**
     * Export
     *
     * @return string base64encode or path etc
     *
     * @throws RuntimeException
     */
    public function export() : string;
}
