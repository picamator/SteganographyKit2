<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

/**
 * Filter manager
 *
 * @package Kernel\Text\Filter
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
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function apply(string $text) : string;
}
