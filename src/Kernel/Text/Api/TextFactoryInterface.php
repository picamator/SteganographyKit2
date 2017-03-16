<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api;

/**
 * Create Text object
 */
interface TextFactoryInterface
{
    /**
     * Create
     *
     * @param string $text
     *
     * @return TextInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(string $text) : TextInterface;
}
