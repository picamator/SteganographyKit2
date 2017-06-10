<?php
namespace Picamator\SteganographyKit2\Kernel\Facade\Api;

use Picamator\SteganographyKit2\Kernel\StegoSystem\Api\StegoSystemInterface;

/**
 * Create StegoSystem
 *
 * @package Kernel\Facade
 */
interface StegoSystemFactoryInterface
{
    /**
     * Create
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create() : StegoSystemInterface;
}
