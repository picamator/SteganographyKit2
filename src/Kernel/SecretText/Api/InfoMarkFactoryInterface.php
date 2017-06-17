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
     * Mark length in bits
     */
    const MARK_LENGTH = 32;

    /**
     * Create
     *
     * @param string $binaryString
     *
     * @return InfoMarkInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(string $binaryString) : InfoMarkInterface;
}
