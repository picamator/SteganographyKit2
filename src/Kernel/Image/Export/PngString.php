<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export to png base64encode string
 *
 * @codeCoverageIgnore
 */
class PngString extends AbstractString
{
    /**
     * @inheritDoc
     */
    final protected function displayImage(ResourceInterface $resource): bool
    {
        return imagepng($resource->getResource());
    }
}
