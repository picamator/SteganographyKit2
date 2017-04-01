<?php
namespace Picamator\SteganographyKit2\Kernel\Image\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

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
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function export(ResourceInterface $resource) : string;
}
