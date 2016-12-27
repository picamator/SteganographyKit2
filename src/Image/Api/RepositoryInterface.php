<?php
namespace Picamator\SteganographyKit2\Image\Api;

use Picamator\SteganographyKit2\Entity\PixelInterface;
use Picamator\SteganographyKit2\Exception\RuntimeException;

/**
 * Repository
 */
interface RepositoryInterface
{
    /**
     * Update
     *
     * @param PixelInterface $pixel
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function update(PixelInterface $pixel);

    /**
     * Export
     *
     * @return ExportInterface
     */
    public function export() : ExportInterface;
}
