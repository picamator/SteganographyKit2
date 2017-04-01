<?php
namespace Picamator\SteganographyKit2\Kernel\Pixel\Api;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface;
use Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface;

/**
 * Repository
 *
 * @package Kernel\Pixel
 */
interface RepositoryInterface
{
    /**
     * Update pixel
     *
     * Pixel updates only in memory, please run export to preserve result.
     *
     * @param PixelInterface $pixel
     * @param array $data ['red' => ..., 'green' => ..., 'blue' => ..., 'alpha' => ...]
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function update(PixelInterface $pixel, array $data);

    /**
     * Insert
     *
     * Pixel updates only in memory, please run export to preserve result.
     *
     * @param PixelInterface $pixel
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function insert(PixelInterface $pixel);

    /**
     * Find
     *
     * @param PointInterface $point
     *
     * @return PixelInterface
     */
    public function find(PointInterface $point) : PixelInterface;

    /**
     * Gets resource
     *
     * @return ResourceInterface
     */
    public function getResource() : ResourceInterface;
}
