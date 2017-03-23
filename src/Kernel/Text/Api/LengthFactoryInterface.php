<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

use Picamator\SteganographyKit2\Kernel\Text\Api\Data\LengthInterface;

/**
 * Create Length object
 *
 * @package Kernel\Text
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
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $text) : LengthInterface;
}
