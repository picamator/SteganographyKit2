<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

/**
 * Create SecretText object
 */
interface SecretTextFactoryInterface
{
    /**
     * Create
     *
     * @param string $secretText
     *
     * @return SecretTextInterface
     */
    public function create(string $secretText) : SecretTextInterface;
}
