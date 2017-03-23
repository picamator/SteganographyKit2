<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\Data\InfoInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\InfoFactoryInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface;
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
 * @package Kernel\Image
 */
class InfoFactory implements InfoFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var SizeFactoryInterface
     */
    private $sizeFactory;

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
     * @param SizeFactoryInterface $sizeFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        SizeFactoryInterface $sizeFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\Image\Data\Info'
    ) {
        $this->objectManager = $objectManager;
        $this->sizeFactory = $sizeFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(string $path) : InfoInterface
    {
        if (array_key_exists($path, $this->infoContainer)) {
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

        $size = $this->sizeFactory->create($imageSize[0], $imageSize[1]);
        $data = [
            'type' => $imageSize[2],
            'attr' => $imageSize[3],
            'bits' => $imageSize['bits'],
            'countChannels' => $imageSize['channels'] ?? 0,
            'mime' => $imageSize['mime'],
            'extraInfo' => $info,
            'iptc' => $this->getIptc($info),
        ];

        $this->infoContainer[$path] = $this->objectManager->create($this->className, [$size, $data]);

        return $this->infoContainer[$path];
    }

    /**
     * Gets IPTC
     *
     * @param array $info
     *
     * @return array
     */
    private function getIptc(array $info) : array
    {
        if (!isset($info['APP13'])) {
            return [];
        }

        $iptc = iptcparse($info['APP13']);
        if ($iptc === false) {
            $iptc = [];
        }

        return $iptc;
    }
}
