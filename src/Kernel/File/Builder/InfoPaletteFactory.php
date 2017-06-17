<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Data\Info;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;

/**
 * Create Info palette object
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class InfoPaletteFactory
{
    /**
     * @var string
     */
    private static $attrTemplate = 'width="%s" height="%s"';

    /**
     * @var string
     */
    private static $name = 'palette.tmp';

    /**
     * @inheritDoc
     */
    public static function create(SizeInterface $size) : InfoInterface
    {
        $data = [
            'type'          => 0,
            'attr'          => sprintf(self::$attrTemplate, $size->getWidth(), $size->getHeight()),
            'bits'          => 8,
            'channels'      => 3,
            'mime'          => '',
            'path'          => '',
            'name'          => self::$name
        ];

        return new Info($size, $data);
    }
}
