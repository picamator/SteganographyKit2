<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Create Pixel object
 *
 * @codeCoverageIgnore
 */
class PixelFactory implements PixelFactoryInterface
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
     * @var IteratorFactoryInterface
     */
    private $iteratorFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param OptionsResolverInterface $optionsResolver
     * @param IteratorFactoryInterface $iteratorFactory
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        OptionsResolverInterface $optionsResolver,
        IteratorFactoryInterface $iteratorFactory,
        string $className = 'Picamator\SteganographyKit2\Entity\Pixel'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->iteratorFactory = $iteratorFactory;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : PixelInterface
    {
        $data['iteratorFactory'] = $data['iteratorFactory'] ?? $this->iteratorFactory;

        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
