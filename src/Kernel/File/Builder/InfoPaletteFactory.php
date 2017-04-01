<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\File\Api\Builder\InfoPaletteFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Info palette object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Info``.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * Check list
 * ----------
 * * Single responsibility ``+``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\File
 *
 * @codeCoverageIgnore
 */
final class InfoPaletteFactory implements InfoPaletteFactoryInterface
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
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'Picamator\SteganographyKit2\Kernel\File\Data\Info'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(SizeInterface $size) : InfoInterface
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

        return $this->objectManager->create($this->className, [$size, $data]);
    }

}
