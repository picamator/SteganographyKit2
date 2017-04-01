<?php
namespace Picamator\SteganographyKit2\Kernel\SecretText\Api;

use Picamator\SteganographyKit2\Kernel\SecretText\Api\Data\SizeInterface;

/**
 * SecretText is an information for hide or protection signature
 *
 * @package Kernel\SecretText
 */
interface SecretTextInterface extends \IteratorAggregate
{
    /**
     * Gets binary text
     *
     * @return string
     */
    public function getBinaryText();

    /**
     * Gets info mark
     *
     * @return InfoMarkInterface
     */
    public function getInfoMark() : InfoMarkInterface;
}
