<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Entity\Iterator;

use Picamator\SteganographyKit2\Entity\Api\Iterator\IteratorFactoryInterface;
use Picamator\SteganographyKit2\Entity\Api\PixelInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Create Iterator object
 *
 * @codeCoverageIgnore
 */
class IteratorFactory implements IteratorFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\Image\Iterator\SerialIterator'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(PixelInterface $pixel) : \Iterator
    {
        $data = ['pixel' => $pixel];

        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
