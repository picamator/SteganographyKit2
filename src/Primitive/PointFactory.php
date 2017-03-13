<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Primitive;

use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Create Point object
 *
 * @codeCoverageIgnore
 */
class PointFactory implements PointFactoryInterface
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
     * @param OptionsResolverInterface $optionsResolver
     * @param string $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        OptionsResolverInterface $optionsResolver,
        string $className = 'Picamator\SteganographyKit2\Primitive\Data\Point'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : PointInterface
    {
        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
