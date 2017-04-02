<?php
namespace Picamator\SteganographyKit2\Kernel\StegoSystem\Api;

use Picamator\SteganographyKit2\Kernel\CoverText\Api\CoverTextInterface;
use Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface;

/**
 * Validator
 *
 * @package Kernel\StegoSystem
 */
interface ValidatorInterface
{
    /**
     * Validate secret text and cover text compatibility
     *
     * @param SecretTextInterface $secretText
     * @param CoverTextInterface $coverText
     *
     * @return bool ``true`` if data is compatible or ``false`` otherwise
     */
    public function validate(SecretTextInterface $secretText, CoverTextInterface $coverText) : bool;
}
