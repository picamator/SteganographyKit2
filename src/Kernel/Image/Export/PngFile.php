<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Export to png file
 *
 * @package Kernel\Image\Export
 *
 * @codeCoverageIgnore
 */
final class PngFile extends AbstractFile
{
    /**
     * @var string
     */
    private static $extension = 'png';

    /**
     * @inheritDoc
     */
    protected function saveImage(ResourceInterface $resource, string $path): bool
    {
        return imagepng($resource->getResource(), $path);
    }

    /**
     * @inheritDoc
     */
    protected function getExtension(): string
    {
        return self::$extension;
    }
}
