<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

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
    final protected function displayImage($resource): bool
    {
        return imagepng($resource);
    }
}
