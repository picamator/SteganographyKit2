<?php
namespace Picamator\SteganographyKit2\StegoSystem\Api;

use Picamator\SteganographyKit2\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\SecretText\Api\SecretTextInterface;
use Picamator\SteganographyKit2\StegoText\Api\StegoTextInterface;

/**
 * StegoSystem is an observer facade over Encode & Decode
 */
interface StegoSystemInterface
{
    /**
     * Encode
     *
     * @param SecretTextInterface $secretText
     * @param CoverTextInterface $coverText
     *
     * @return StegoTextInterface
     */
    public function encode(SecretTextInterface $secretText, CoverTextInterface $coverText) : StegoTextInterface;

    /**
     * Decode
     *
     * @param StegoTextInterface $stegoText
     *
     * @return SecretTextInterface
     */
    public function decode(StegoTextInterface $stegoText) : SecretTextInterface;

    /**
     * Attach
     *
     * @param string $name
     * @param ObserverInterface $observer
     *
     * @return StegoSystemInterface
     */
    public function attach(string $name, ObserverInterface $observer) : StegoSystemInterface;

    /**
     * Detach
     *
     * @param string $name
     * @param ObserverInterface $observer
     *
     * @return StegoSystemInterface
     */
    public function detach(string $name, ObserverInterface $observer) : StegoSystemInterface;

    /**
     * Notify
     *
     * @param string $name
     * @param array $data
     */
    public function notify(string $name, ...$data);
}
