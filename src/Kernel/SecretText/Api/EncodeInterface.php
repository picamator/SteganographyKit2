<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * Encode data to SecretText
 *
 * @package Kernel\SecretText
 */
interface EncodeInterface
{
    /**
     * Encode
     *
     * @param mixed $data
     *
     * @return SecretTextInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
     */
    public function encode($data) : SecretTextInterface;
}
