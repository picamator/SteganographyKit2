<?php
namespace Picamator\SteganographyKit2\Text\Api;

use Picamator\SteganographyKit2\Text\Api\Data\AsciiInterface;

/**
 * Create ascii value object
 */
interface AsciiFactoryInterface
{
    /**
     * Create
     *
     * @param string $char
     *
     * @return AsciiInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function create(string $char) : AsciiInterface;
}
