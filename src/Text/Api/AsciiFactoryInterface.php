<?php
namespace Picamator\SteganographyKit2\Text;

use Picamator\SteganographyKit2\Text\Data\AsciiInterface;

/**
 * Create ascii value object
 */
interface AsciiFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return AsciiInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : AsciiInterface;
}
