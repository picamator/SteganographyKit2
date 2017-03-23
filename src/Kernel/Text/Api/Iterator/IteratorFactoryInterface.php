<?php
namespace Picamator\SteganographyKit2\Kernel\Text\Api\Iterator;

use Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface;

/**
 * Create Iterator object
 *
 * @package Kernel\Text\Iterator
 */
interface IteratorFactoryInterface
{
    /**
     * Create
     *
     * @param TextInterface $text
     *
     * @return \Iterator
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(TextInterface $text) : \Iterator;
}
