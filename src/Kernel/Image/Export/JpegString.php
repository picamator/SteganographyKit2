<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Export to jpeg base64encode string
 *
 * @package Kernel\Image\Export
 *
 * @codeCoverageIgnore
 */
final class JpegString extends AbstractString
{
    /**
     * @inheritDoc
     */
    protected function displayImage(ResourceInterface $resource): bool
    {
        return imagejpeg($resource->getResource());
    }
}
