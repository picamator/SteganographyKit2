<?php
namespace Picamator\SteganographyKit2\Text;

/**
 * Filter manager
 */
interface FilterManagerInterface
{
    /**
     * Add filter
     *
     * @param FilterInterface $filter
     *
     * @return FilterManagerInterface
     */
    public function addFiler(FilterInterface $filter) : FilterManagerInterface;

    /**
     * Apply all filters
     *
     * @return string
     */
    public function apply() : string;
}
