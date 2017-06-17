<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;

/**
 * Create Writable path value object
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class WritablePathFactory
{
    /**
     * @inheritDoc
     */
    public static function create(string $path) : WritablePathInterface
    {
        $path = rtrim($path, '/\\');

        if(!file_exists($path) && !mkdir($path, 0755, true)) {
            throw new InvalidArgumentException(
                sprintf('Impossible create sub-folders structure for destination "%s"', $path)
            );
        }

        if(!is_writable($path)) {
            throw new InvalidArgumentException(
                sprintf('Destination does not have writable permission "%s"', $path)
            );
        }

        return new WritablePath($path);
    }
}
