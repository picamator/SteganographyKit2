<?php
namespace Picamator\SteganographyKit2\Text;

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
     */
    public function filter(string $text) : string;
}
