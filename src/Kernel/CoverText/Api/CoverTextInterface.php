<?php
namespace Picamator\SteganographyKit2\Kernel\CoverText\Api;

use Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface;

/**
 * CoverText is an image container for SecretText, when CoverText holds SecretText it becomes StegoText
 *
 * @package Kernel\CoverText
 */
interface CoverTextInterface extends \RecursiveIterator
{
    /**
     * Gets image
     *
     * @return ImageInterface
     */
    public function getImage() : ImageInterface;
}
