<?php
namespace Picamator\SteganographyKit2\Text\Api\Iterator;

use Picamator\SteganographyKit2\Text\Api\TextInterface;

/**
 * Create Iterator object
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
     * @throws \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function create(TextInterface $text) : \Iterator;
}
