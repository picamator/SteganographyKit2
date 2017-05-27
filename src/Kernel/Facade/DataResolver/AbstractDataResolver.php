<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Facade\DataResolver;

use Picamator\SteganographyKit2\Kernel\Facade\Api\Builder\DataFactoryInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\DataInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\DataResolverInterface;

/**
 * Data resolver
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Resolve Data value object for internal api.
 *
 * State
 * -----
 * No state
 *
 * Immutability
 * ------------
 * Object is mutable.
 *
 * Dependency injection
 * --------------------
 * Extend only
 *
 * @package Kernel\Facade
 */
abstract class AbstractDataResolver implements DataResolverInterface
{
    /**
     * @var DataFactoryInterface
     */
    protected $dataFactory;

    /**
     * @var DataResolverInterface
     */
    private $resolver;

    /**
     * @param DataFactoryInterface $dataFactory
     */
    public function __construct(DataFactoryInterface $dataFactory)
    {
        $this->dataFactory = $dataFactory;
    }

    /**
     * @inheritDoc
     */
    final public function resolve($data): DataInterface
    {
        $result =  $this->process($data);
        if ($result === null && $this->resolver !== null) {
            $result =  $this->resolver->resolve($data);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    final public function setResolver(DataResolverInterface $resolver): DataResolverInterface
    {
        if ($this->resolver === null) {
            $this->resolver = $resolver;

            return $this;
        }

        $this->resolver->setResolver($resolver);

        return $this;
    }

    /**
     * @param $data
     *
     * @return DataInterface | null
     */
    abstract protected function process($data);
}
