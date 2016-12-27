<?php
namespace Picamator\SteganographyKit2\Image\Api\Data;

/**
 * Image value object
 */
interface ImageInterface extends \IteratorAggregate
{
    /**
     * Gets image
     *
     * @return resource
     */
    public function getImage();

    /**
     * Gets size
     *
     * @return int
     */
    public function getSize() : int;

    /**
     * Gets width
     *
     * @return int
     */
    public function getWidth() : int;

    /**
     * Gets height
     *
     * @return int
     */
    public function getHeight() : int;

    /**
     * Gets mime
     *
     * @return string
     */
    public function getMime() : string;
}
