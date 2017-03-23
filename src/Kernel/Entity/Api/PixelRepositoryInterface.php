<?php
namespace Picamator\SteganographyKit2\Kernel\Entity\Api;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;

/**
 * Pixel Repository
 */
interface PixelRepositoryInterface
{
    /**
     * Update pixel
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
     * @param PixelInterface $pixel
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function insert(PixelInterface $pixel);
}
