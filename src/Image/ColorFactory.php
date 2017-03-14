<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create Color object
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
        $className = 'Picamator\SteganographyKit2\Image\Data\Color'
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
