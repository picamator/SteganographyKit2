<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export to png file
 *
 * @codeCoverageIgnore
 */
class PngFile extends AbstractFile
{
    /**
     * @inheritDoc
     */
    final protected function saveImage(ResourceInterface $resource, string $path): bool
    {
        return imagepng($resource->getResource(), $path);
    }
}
