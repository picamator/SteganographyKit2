<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Text\Api\FilterInterface;
use Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface;

/**
 * Create ascii value object
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
