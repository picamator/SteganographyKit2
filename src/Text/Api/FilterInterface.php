<?php
namespace Picamator\SteganographyKit2\Text\Api;

/**
 * Filter text
 *
 * It's convert original text to base64encode, zip, encrypt etc.
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
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function filter(string $text) : string;
}
