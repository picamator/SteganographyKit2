<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Color object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``Color``.
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
 * @package Kernel\Image
 *
 * @codeCoverageIgnore
 */
class ColorFactory implements ColorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ByteInterface
     */
    private $byte;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ByteInterface $byte
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ByteInterface $byte,
        $className = 'Picamator\SteganographyKit2\Kernel\Image\Data\Color'
    ) {
        $this->objectManager = $objectManager;
        $this->byte = $byte;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ColorInterface
    {
        $red = $data['red'] ?? $this->byte;
        $green = $data['green'] ?? $this->byte;
        $blue = $data['blue'] ?? $this->byte;
        $alpha = $data['alpha'] ?? $this->byte;

        return $this->objectManager->create($this->className, [$red, $green, $blue, $alpha]);
    }
}
