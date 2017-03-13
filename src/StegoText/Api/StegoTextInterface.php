<?php
namespace Picamator\SteganographyKit2\StegoText\Api;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;

/**
 * StegoText is a result of combining SecretText into CoverText
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
