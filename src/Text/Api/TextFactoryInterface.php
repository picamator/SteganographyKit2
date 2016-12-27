<?php
namespace Picamator\SteganographyKit2\Text;

/**
 * Create text
 */
interface TextFactoryInterface
{
    /**
     * Create
     *
     * @param array $data
     *
     * @return TextInterface
     *
     * @throws \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function create(array $data) : TextInterface;
}
