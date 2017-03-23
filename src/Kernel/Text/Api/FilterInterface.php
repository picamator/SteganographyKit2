<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

/**
 * Filter text
 *
 * It's convert original text to base64encode, zip, encrypt etc.
 *
 * @package Kernel\Text\Filter
 */
interface FilterInterface
{
    /**
     * Filter
     *
     * @param string $text
     *
     * @return string
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function filter(string $text) : string;
}
