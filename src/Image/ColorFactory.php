<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Image;

use Picamator\SteganographyKit2\Image\Api\ColorFactoryInterface;
use Picamator\SteganographyKit2\Image\Api\Data\ColorInterface;
use Picamator\SteganographyKit2\Util\Api\ObjectManagerInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Create Color object
 *
 * @codeCoverageIgnore
 */
class ColorFactory implements ColorFactoryInterface
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
        $className = 'Picamator\SteganographyKit2\Image\Data\Color'
    ) {
        $this->objectManager = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data) : ColorInterface
    {
        return $this->objectManager->create($this->className, [$this->optionsResolver, $data]);
    }
}
