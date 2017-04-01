<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Resource;

/**
 * Resource png image
 *
 * @package Kernel\File\Resource
 *
 * @codeCoverageIgnore
 */
final class PngResource extends AbstractResource
{
    /**
     * @inheritDoc
     */
    protected function getImage(string $path)
    {
        return imagecreatefrompng($path);
    }
}
