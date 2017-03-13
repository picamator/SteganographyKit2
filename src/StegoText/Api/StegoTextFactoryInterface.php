<?php
namespace Picamator\SteganographyKit2\StegoText\Api;

use Picamator\SteganographyKit2\Image\Api\ImageInterface;

/**
 * Create StegoText object
 */
interface StegoTextFactoryInterface
{
    /**
     * Create
     *
     * @param ImageInterface $image
     *
     * @return StegoTextInterface
     */
    public function create(ImageInterface $image) : StegoTextInterface;
}
