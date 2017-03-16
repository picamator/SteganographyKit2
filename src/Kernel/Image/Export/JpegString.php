<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

/**
 * Export to jpeg base64encode string
 *
 * @codeCoverageIgnore
 */
class JpegString extends AbstractString
{
    /**
     * @inheritDoc
     */
    final protected function displayImage($resource): bool
    {
        return imagejpeg($resource);
    }
}
