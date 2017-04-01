<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * Create SecretText object
 *
 * @package Kernel\SecretText
 */
interface SecretTextFactoryInterface
{
    /**
     * Create
     *
     * @param InfoMarkInterface $infoMark
     * @param string $secretText
     *
     * @return SecretTextInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function create(InfoMarkInterface $infoMark, string $secretText) : SecretTextInterface;
}
