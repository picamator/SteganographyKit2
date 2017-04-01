<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

/**
 * Filter manager
 *
 * @package Kernel\Text\Filter
 */
interface FilterManagerInterface extends \Countable
{
    /**
     * Attach filter
     *
     * @param FilterInterface $filter
     *
     * @return FilterManagerInterface
     */
    public function attach(FilterInterface $filter): FilterManagerInterface;

    /**
     * Attach all filters
     *
     * @param array $filterList
     *
     * @return FilterManagerInterface
     */
    public function attachAll(array $filterList): FilterManagerInterface;

    /**
     * Detach filter
     *
     * @param FilterInterface $filter
     *
     * @return FilterManagerInterface
     */
    public function detach(FilterInterface $filter): FilterManagerInterface;

    /**
     * Remove all filters
     *
     * @return FilterManagerInterface
     */
    public function removeAll(): FilterManagerInterface;

    /**
     * Gets filter list
     *
     * @return array
     */
    public function getList() : array;

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
