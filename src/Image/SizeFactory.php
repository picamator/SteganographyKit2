<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Exception\RuntimeException;
use Picamator\SteganographyKit2\Image\Api\Data\SizeInterface;
use Picamator\SteganographyKit2\Image\Api\SizeFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

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
     * @var OptionsResolverInterface
     */
    private $optionsResolver;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param OptionsResolverInterface $optionsResolver
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        OptionsResolverInterface $optionsResolver,
        string $className = 'Picamator\SteganographyKit2\Image\Data\Size'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
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

        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
