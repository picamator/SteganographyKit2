<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image\Resource;

/**
 * Resource image implementation for different image types
 *
 * It's part of Bridge pattern between Abstraction "Image" and "Resource" implementation
 * It helps to extend application with different image type
 *
 * @codeCoverageIgnore
 */
class PngResource extends AbstractResource
{
    /**
     * @inheritDoc
     */
    final protected function getImage(string $path)
    {
        return imagecreatefrompng($path);
    }
}
