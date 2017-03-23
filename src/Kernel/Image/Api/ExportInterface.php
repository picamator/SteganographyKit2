<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;

/**
 * Export Image
 *
 * @package Kernel\Image\Export
 */
interface ExportInterface
{
    /**
     * Export
     *
     * @param ResourceInterface $resource
     *
     * @return string base64encode or path etc
     *
     * @throws RuntimeException
     */
    public function export(ResourceInterface $resource) : string;
}
