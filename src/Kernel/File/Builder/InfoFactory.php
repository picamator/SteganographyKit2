<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\Builder;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Builder\InfoFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create Info object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * * Validate path
 * * Create ``Info``
 *
 * State
 * -----
 * * Internal cache info data using path as a unique key
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
 * * Single responsibility ``-``
 * * Tell don't ask ``+``
 * * No logic leak ``+``
 * * Object is ready after creation ``+``
 * * Constructor depends on less then 5 classes ``+``
 *
 * @package Kernel\File
 */
final class InfoFactory implements InfoFactoryInterface
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
     * @var array
     */
    private $infoContainer = [];

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
    public function create(string $path) : InfoInterface
    {
        if (isset($this->infoContainer[$path])) {
            return $this->infoContainer[$path];
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

        $this->infoContainer[$path] = $this->objectManager->create($this->className, [$size, $data]);

        return $this->infoContainer[$path];
    }

}
