<?php
namespace Picamator\SteganographyKit2\Kernel\StegoText\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;

/**
 * StegoText is a result of combining SecretText into CoverText
 *
 * @package Kernel\StegoText
 */
interface StegoTextInterface extends \RecursiveIterator
{
    /**
     * Gets image
     *
     * @return ImageInterface
     */
    public function getImage() : ImageInterface;
}
