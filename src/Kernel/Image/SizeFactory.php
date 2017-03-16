<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Size object
 *
 * @codeCoverageIgnore
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
    public function create(string $path) : SizeInterface
    {
        $size = getimagesize($path);
        if($size === false) {
            throw new RuntimeException(
                sprintf('Cannot calculate image size "%s"', $path)
            );
        }

        $data = [
            'width' => $size[0],
            'height' => $size[1],
            'type' => $size[2],
            'attr' => $size[3],
            'bits' => $size['bits'],
            'channels' => $size['channels'] ?? 0,
            'mime' => $size['mime'],
        ];

        return $this->objectManager->create($this->className, [$data]);
    }
}
