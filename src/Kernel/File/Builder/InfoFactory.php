<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Data\Info;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;

/**
 * Create Info object
 *
 * @package Kernel\File
 */
final class InfoFactory
{
    /**
     * @var array
     */
    private static $infoContainer = [];

    /**
     * @inheritDoc
     */
    public function create(string $path) : InfoInterface
    {
        if (isset(self::$infoContainer[$path])) {
            return self::$infoContainer[$path];
        }

        $imageSize = getimagesize($path, $info);
        // @codeCoverageIgnoreStart
        if($imageSize === false) {
            throw new RuntimeException(
                sprintf('Cannot calculate image size "%s"', $path)
            );
        }
        // @codeCoverageIgnoreEnd

        $size = SizeFactory::create($imageSize[0], $imageSize[1]);
        $data = [
            'type'          => $imageSize[2],
            'attr'          => $imageSize[3],
            'bits'          => $imageSize['bits'],
            'channels'      => $imageSize['channels'],
            'mime'          => $imageSize['mime'],
            'path'          => $path,
            'name'          => pathinfo($path, PATHINFO_BASENAME)
        ];

        self::$infoContainer[$path] = new Info($size, $data);

        return self::$infoContainer[$path];
    }
}
