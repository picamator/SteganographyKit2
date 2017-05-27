<?php
namespace Picamator\SteganographyKit2\Kernel\File\Api;

use Picamator\SteganographyKit2\Kernel\File\Api\Data\CoverInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\SecretInterface;
use Picamator\SteganographyKit2\Kernel\File\Api\Data\StegoInterface;

/**
 * Facade for all Steganography algorithms
 *
 * @package Kernel\Facade
 */
interface FacadeInterface
{
    /**
     * Encode
     *
     * @param SecretInterface $secret
     * @param CoverInterface $cover
     *
     * @return string depends on what export strategy is used e.g. base64 string or path to exported file
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function encode(SecretInterface $secret, CoverInterface $cover) : StegoInterface;

    /**
     * Decode
     *
     * @param StegoInterface $stego
     *
     * @return SecretInterface
     *
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     * @throws \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function decode(StegoInterface $stego) : SecretInterface;
}
