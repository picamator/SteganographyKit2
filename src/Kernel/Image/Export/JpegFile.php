<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;

/**
 * Export to jpeg file
 *
 * @package Kernel\Image\Export
 *
 * @codeCoverageIgnore
 */
final class JpegFile extends AbstractFile
{
    /**
     * @var string
     */
    private static $extension = 'jpg';

    /**
     * @inheritDoc
     */
    protected function saveImage(ResourceInterface $resource, string $path): bool
    {
        return imagejpeg($resource->getResource(), $path);
    }

    /**
     * @inheritDoc
     */
    protected function getExtension(): string
    {
        return self::$extension;
    }
}
