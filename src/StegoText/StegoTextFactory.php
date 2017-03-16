<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\StegoText;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;

/**
 * Create StegoText object
 *
 * @codeCoverageIgnore
 */
class StegoTextFactory implements StegoTextFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\StegoText\StegoText'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(ImageInterface $image) : StegoTextInterface
    {
        return $this->objectManager->create($this->className, [$image]);
    }
}
