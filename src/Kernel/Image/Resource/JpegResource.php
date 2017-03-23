<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Resource;

/**
 * Resource jpeg image
 *
 * @codeCoverageIgnore
 */
class JpegResource extends AbstractResource
{
    /**
     * @inheritDoc
     */
    final protected function getImage(string $path)
    {
        return imagecreatefromjpeg($path);
    }
}
