<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface;
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
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $className = 'Picamator\SteganographyKit2\Kernel\Image\Data\Color'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ColorInterface
    {
        $red = $data['red'] ?? null;
        $green = $data['green'] ?? null;
        $blue = $data['blue'] ?? null;
        $alpha = $data['alpha'] ?? null;

        return $this->objectManager->create($this->className, [$red, $green, $blue, $alpha]);
    }
}
