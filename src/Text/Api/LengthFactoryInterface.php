<?php
namespace Picamator\SteganographyKit2\Text\Api;

use Picamator\SteganographyKit2\Text\Api\Data\LengthInterface;

/**
 * Create Length object
 */
interface LengthFactoryInterface
{
    /**
     * Create
     *
     * @param string $text
     *
     * @return LengthInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function create(string $text) : LengthInterface;
}
