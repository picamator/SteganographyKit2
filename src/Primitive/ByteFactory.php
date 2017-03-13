<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Primitive;

use Picamator\SteganographyKit2\Primitive\Api\ByteFactoryInterface;
use Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Create Byte object
 *
 * @codeCoverageIgnore
 */
class ByteFactory implements ByteFactoryInterface
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
        string $className = 'Picamator\SteganographyKit2\Primitive\Data\Byte'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ByteInterface
    {
        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
