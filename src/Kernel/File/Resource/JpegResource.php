<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Resource;

/**
 * Resource jpeg image
 *
 * @package Kernel\File\Resource
 *
 * @codeCoverageIgnore
 */
final class JpegResource extends AbstractResource
{
    /**
     * @inheritDoc
     */
    protected function getImage(string $path)
    {
        return imagecreatefromjpeg($path);
    }
}
