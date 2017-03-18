<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export to jpeg file
 *
 * @codeCoverageIgnore
 */
class JpegFile extends AbstractFile
{
    /**
     * @inheritDoc
     */
    final protected function saveImage(ResourceInterface $resource, string $path): bool
    {
        return imagejpeg($resource->getResource(), $path);
    }
}
