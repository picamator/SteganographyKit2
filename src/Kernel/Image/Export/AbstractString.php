<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Image\Export;

use Picamator\SteganographyKit2\Kernel\Exception\RuntimeException;
use Picamator\SteganographyKit2\Kernel\Image\Api\ExportInterface;
use Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface;

/**
 * Export image to base64encode string
 *
 * It implements template pattern
 */
abstract class AbstractString implements ExportInterface
{
    /**
     * @inheritDoc
     */
    final public function export(ResourceInterface $resource): string
    {
        ob_start();
            $result = $this->displayImage($resource);
            $contents = ob_get_contents();
        ob_end_clean();

        if ($result === false) {
            throw new RuntimeException(
                sprintf('Failed exporting image "%s"', $resource->getName())
            );
        }

        return base64_encode($contents);
    }

    /**
     * Display image
     *
     * @param ResourceInterface $resource
     *
     * @return bool
     */
    abstract protected function displayImage(ResourceInterface $resource) : bool;
}
