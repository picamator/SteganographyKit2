<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Export to png base64encode string
 *
 * @package Kernel\Image\Export
 *
 * @codeCoverageIgnore
 */
final class PngString extends AbstractString
{
    /**
     * @inheritDoc
     */
    protected function displayImage(ResourceInterface $resource): bool
    {
        return imagepng($resource->getResource());
    }
}
