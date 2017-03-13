<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Export;

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
    final protected function saveImage($resource, string $path): bool
    {
        return imagepng($resource, $path);
    }
}
