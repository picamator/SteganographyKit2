<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

use Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface;

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
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(string $char) : AsciiInterface;
}
