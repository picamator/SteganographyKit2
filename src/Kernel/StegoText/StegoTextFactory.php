<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\StegoText;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextFactoryInterface;
use Picamator\SteganographyKit2\Kernel\StegoText\Api\StegoTextInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create StegoText object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``StegoText``.
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
 * @package Kernel\StegoText
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
        string $className = 'Picamator\SteganographyKit2\Kernel\StegoText\StegoText'
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
