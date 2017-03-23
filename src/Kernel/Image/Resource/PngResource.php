<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Resource;

/**
 * Resource png image
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
