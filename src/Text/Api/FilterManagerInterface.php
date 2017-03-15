<?php
namespace Picamator\SteganographyKit2\Text\Api;

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
    public function addFilter(FilterInterface $filter) : FilterManagerInterface;

    /**
     * Apply all filters
     *
     * @param string $text
     *
     * @return string
     *
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function apply(string $text) : string;
}
