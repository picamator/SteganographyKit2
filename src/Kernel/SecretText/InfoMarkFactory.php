<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\SizeFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface;
use Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface;

/**
 * Create InfoMark object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Create ``InfoMark``.
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
 * @package Kernel\SecretText
 */
final class InfoMarkFactory implements InfoMarkFactoryInterface
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
     * @param ObjectManagerInterface $objectManager
     * @param SizeFactoryInterface $sizeFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        SizeFactoryInterface $sizeFactory,
        string $className = 'Picamator\SteganographyKit2\Kernel\SecretText\InfoMark'
    ) {
        $this->objectManager = $objectManager;
        $this->sizeFactory = $sizeFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(int $width, int $height) : InfoMarkInterface
    {
        $size = $this->sizeFactory->create($width, $height);

        return $this->objectManager->create($this->className, [$size]);
    }
}
