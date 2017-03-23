<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Size object
 */
class SizeFactory implements SizeFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\Kernel\Image\Data\Size'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(int $width, int $height) : SizeInterface
    {
        if ($width <= 0 || $height <= 0) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument width "%s" or height "%s". Dimension data should be positive integers.', $width, $height)
            );
        }

        return $this->objectManager->create($this->className, [$width, $height]);
    }
}
