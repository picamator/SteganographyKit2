<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

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
    final protected function saveImage($resource, string $path): bool
    {
        return imagejpeg($resource, $path);
    }
}
