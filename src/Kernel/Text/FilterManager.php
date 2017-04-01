<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;

/**
 * Create ascii value object
 *
 * Class type
 * ----------
 * Sharable service.
 *
 * Responsibility
 * --------------
 * Manage to apply ``Filter`` chain
 *
 * State
 * -----
 * * Filter container
 *
 * Immutability
 * ------------
 * Object is mutable.
 *
 * Dependency injection
 * --------------------
 * Only as a constructor argument.
 *
 * @package Kernel\Text\Filter
 */
class FilterManager implements FilterManagerInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $container;

    public function __construct()
    {
        $this->container = new \SplObjectStorage();
    }

    /**
     * @inheritDoc
     */
    public function attach(FilterInterface $filter): FilterManagerInterface
    {
        if ($this->container->contains($filter)) {
            return $this;
        }

        $this->container->attach($filter);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function attachAll(array $filterList): FilterManagerInterface
    {
        foreach ($filterList as $item) {
            $this->attach($item);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function detach(FilterInterface $filter): FilterManagerInterface
    {
        $this->container->detach($filter);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(): FilterManagerInterface
    {
        $this->container->removeAll($this->container);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->container->count();
    }

    /**
     * @inheritDoc
     */
    public function getList() : array
    {
        $filterList = [];
        foreach ($this->container as $item) {
            $filterList[] = $item;
        }

        return $filterList;
    }

    /**
     * @inheritDoc
     */
    public function apply(string $text): string
    {
        /** @var FilterInterface $item */
        foreach ($this->container as $item) {
            $text = $item->filter($text);
        }

        return $text;
    }
}
