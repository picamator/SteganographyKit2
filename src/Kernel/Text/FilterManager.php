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
 * Object is immutable.
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
     * @var array
     */
    private $filterContainer = [];

    /**
     * @inheritDoc
     */
    public function addFilter(FilterInterface $filter): FilterManagerInterface
    {
        $this->filterContainer[] = $filter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function apply(string $text): string
    {
        /** @var FilterInterface $item */
        foreach ($this->filterContainer as $item) {
            $text = $item->filter($text);
        }

        return $text;
    }
}
