<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * Create InfoMark object
 *
 * @package Kernel\SecretText
 */
interface InfoMarkFactoryInterface
{
    /**
     * Create
     *
     * @param int $width
     * @param int $height
     *
     * @return InfoMarkInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function create(int $width, int $height) : InfoMarkInterface;
}
