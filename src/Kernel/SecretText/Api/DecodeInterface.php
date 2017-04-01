<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * Decode SecretText to original data
 *
 * @package Kernel\SecretText
 */
interface DecodeInterface
{
    /**
     * Decode
     *
     * @param SecretTextInterface $secretText
     *
     * @return mixed
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
     */
    public function decode(SecretTextInterface $secretText);
}
