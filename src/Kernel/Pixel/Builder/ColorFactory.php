<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Pixel\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface;
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
 * @package Kernel\Pixel
 *
 * @codeCoverageIgnore
 */
final class ColorFactory implements ColorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ByteInterface
     */
    private $nullByte;

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
        $className = 'Picamator\SteganographyKit2\Kernel\Pixel\Data\Color'
    ) {
        $this->objectManager = $objectManager;
        $this->nullByte = $byte;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ColorInterface
    {
        $red = $data['red'] ?? $this->nullByte;
        $green = $data['green'] ?? $this->nullByte;
        $blue = $data['blue'] ?? $this->nullByte;
        $alpha = $data['alpha'] ?? $this->nullByte;

        return $this->objectManager->create($this->className, [$red, $green, $blue, $alpha]);
    }
}
